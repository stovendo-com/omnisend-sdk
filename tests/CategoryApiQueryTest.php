<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
 */

declare(strict_types=1);

namespace Stovendo\Omnisend\Tests;

use Http\Discovery\Psr17Factory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Stovendo\Omnisend\OmnisendApiClient;
use Stovendo\Omnisend\Serializer;
use Stovendo\Omnisend\Trait\CategoryApiTrait;

class RecordingHttpClient implements ClientInterface
{
    public ?RequestInterface $lastRequest = null;

    public function __construct(private ResponseInterface $response)
    {
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $this->lastRequest = $request;

        return $this->response;
    }
}

#[CoversClass(CategoryApiTrait::class)]
class CategoryApiQueryTest extends TestCase
{
    public function test_get_categories_uses_offset_and_limit_query(): void
    {
        $psr17Factory = new Psr17Factory();
        $response = $psr17Factory->createResponse(200);
        $response->getBody()->write('{"categories": []}');
        $response->getBody()->rewind();

        $client = new RecordingHttpClient($response);

        $api = new OmnisendApiClient(
            apikey: 'test',
            httpClient: $client,
            psrFactory: $psr17Factory,
            serializer: new Serializer(),
            endpoint: 'https://api.example.com'
        );

        $api->getCategories(5, 10);

        $lastRequest = $client->lastRequest;
        $this->assertInstanceOf(RequestInterface::class, $lastRequest);
        $this->assertSame('offset=5&limit=10', $lastRequest->getUri()->getQuery());
    }
}
