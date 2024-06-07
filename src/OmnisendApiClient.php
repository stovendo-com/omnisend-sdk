<?php

/**
 * @copyright © UAB NFQ Technologies
 *
 * This Software is the property of NFQ Technologies
 * and is protected by copyright law – it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license key
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * Contact UAB NFQ Technologies:
 * E-mail: info@nfq.lt
 * https://www.nfq.lt
 */

declare(strict_types=1);

namespace Stovendo\Omnisend;

use Http\Discovery\Psr17Factory;
use Http\Discovery\Psr18Client;
use JsonException;
use Psr\Http\Client\ClientInterface;
use Stovendo\Omnisend\Exception\CartNotFoundException;
use Stovendo\Omnisend\Exception\CategoryAlreadyExistsException;
use Stovendo\Omnisend\Exception\CategoryNotFoundException;
use Stovendo\Omnisend\Exception\OrderNotFoundException;
use Stovendo\Omnisend\Exception\ProductAlreadyExistsException;
use Stovendo\Omnisend\Exception\ProductAlreadyInCartException;
use Stovendo\Omnisend\Exception\ProductNotFoundException;
use Stovendo\Omnisend\Trait\CartApiTrait;
use Stovendo\Omnisend\Trait\CategoryApiTrait;
use Stovendo\Omnisend\Trait\ContactApiTrait;
use Stovendo\Omnisend\Trait\OrderApiTrait;
use Stovendo\Omnisend\Trait\ProductApiTrait;

readonly class OmnisendApiClient implements OmnisendApi
{
    use CartApiTrait;
    use CategoryApiTrait;
    use ContactApiTrait;
    use OrderApiTrait;
    use ProductApiTrait;

    public function __construct(
        private string $apikey,
        private ClientInterface $httpClient = new Psr18Client(),
        private Psr17Factory $psrFactory = new Psr17Factory(),
        private Serializer $serializer = new Serializer(),
        private string $endpoint = 'https://api.omnisend.com/v3'
    ) {
    }

    public function ping(): bool
    {
        try {
            $this->sendRequest(method: 'GET', endpoint: '/contacts', query: ['limit' => 1]);

            return true;
        } catch (OmnisendException) {
            return false;
        }
    }

    /**
     * @template T of object
     *
     * @param class-string<T>                $expectedType
     * @param array<string, bool|int|string> $query
     *
     * @phpstan-return T
     */
    private function get(string $endpoint, string $expectedType, array $query = []): object
    {
        $responseBody = $this->sendRequest(method: 'GET', endpoint: $endpoint, query: $query);

        return $this->serializer->deserialize($responseBody, $expectedType);
    }

    /**
     * @param array<mixed> $serializerContext
     */
    private function patch(string $endpoint, mixed $payload, array $serializerContext = []): void
    {
        $this->sendRequest('PATCH', $endpoint, $payload, $serializerContext);
    }

    /**
     * @param array<mixed> $serializerContext
     */
    private function put(string $endpoint, mixed $payload, array $serializerContext = []): void
    {
        $this->sendRequest('PUT', $endpoint, $payload, $serializerContext);
    }

    /**
     * @template T of object
     *
     * @param null|class-string<T> $expectedType
     *
     * @phpstan-return ($expectedType is null ? null : T)
     */
    private function post(string $endpoint, mixed $payload, ?string $expectedType = null): ?object
    {
        $responseBody = $this->sendRequest('POST', $endpoint, $payload);

        if ($expectedType === null) {
            return null;
        }

        return $this->serializer->deserialize($responseBody, $expectedType);
    }

    private function delete(string $endpoint, string $id): void
    {
        $this->sendRequest('DELETE', $endpoint.'/'.$id);
    }

    /**
     * @param array<mixed>                   $serializerContext
     * @param array<string, bool|int|string> $query
     */
    private function sendRequest(string $method, string $endpoint, mixed $payload = null, array $serializerContext = [], array $query = []): string
    {
        $uri = $this->psrFactory
            ->createUri($this->endpoint.$endpoint)
            ->withQuery(http_build_query($query))
        ;

        $request = $this->psrFactory
            ->createRequest($method, $uri)
            ->withHeader('X-API-KEY', $this->apikey)
            ->withHeader('Accept', 'application/json, text/plain, */*');

        if (in_array($method, ['POST', 'PUT', 'PATCH'], true)) {
            $request = $request->withHeader('Content-Type', 'application/json');
        }

        if ($payload) {
            $json = $this->serializer->serialize($payload, $serializerContext);
            $request = $request->withBody($this->psrFactory->createStream($json));
        }

        $response = $this->httpClient->sendRequest($request);
        $response->getBody()->seek(0);
        $responseBody = $response->getBody()->getContents();

        if ($response->getStatusCode() >= 400) {
            $defaultError = sprintf('Unknown  Omnisend API error (%s) while trying to send request: %s %s', $response->getStatusCode(), $method, $endpoint);
            $error = $this->getErrorMessage($responseBody) ?? $defaultError;

            throw $this->getMatchingException($error);
        }

        return $responseBody;
    }

    private function getMatchingException(string $message): OmnisendException
    {
        $map = [
            '#product not found#' => ProductNotFoundException::class,
            '#Product with \'(.*)\' productID doesn\'t exist#' => ProductNotFoundException::class,
            '#Product with ProductID `(.*)` not found#' => ProductNotFoundException::class,
            '#Product with \'(.*)\' productID already exists#' => ProductAlreadyExistsException::class,
            '#Category with categoryID \'(.*)\' exists#' => CategoryAlreadyExistsException::class,
            '#Category with \'(.*)\' categoryID not found#' => CategoryNotFoundException::class,
            '#Category with categoryID \'(.*)\' doesn\'t exist#' => CategoryNotFoundException::class,
            '#Product with cartProductID (.*) already exists in the Cart#' => ProductAlreadyInCartException::class,
            '#Cart with (.*) cartID not found#' => CartNotFoundException::class,
            '#Order with \'(.*)\' orderID not found#' => OrderNotFoundException::class,
        ];

        foreach ($map as $pattern => $exception) {
            if (preg_match($pattern, $message) === 1) {
                return new $exception();
            }
        }

        return new OmnisendException($message);
    }

    private function getErrorMessage(string $responseBody): ?string
    {
        try {
            $decoded = json_decode($responseBody, true, 512, \JSON_THROW_ON_ERROR);
            $error = $decoded['error'] ?? '';
            if (isset($decoded['fields'])) {
                $error .= ' Details: '.json_encode($decoded['fields']);
            }

            return trim($error);
        } catch (JsonException) {
        }

        return null;
    }
}
