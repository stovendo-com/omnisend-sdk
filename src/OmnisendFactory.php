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
use Psr\Http\Client\ClientInterface;

readonly class OmnisendFactory
{
    public function __construct(
        private ClientInterface $httpClient = new Psr18Client(),
        private Psr17Factory $psrFactory = new Psr17Factory(),
        private Serializer $serializer = new Serializer(),
        private string $endpoint = 'https://api.omnisend.com/v3',
    ) {
    }

    public function create(string $apikey): OmnisendApi
    {
        return new OmnisendApiClient(
            apikey: $apikey,
            httpClient: $this->httpClient,
            psrFactory: $this->psrFactory,
            serializer: $this->serializer,
            endpoint: $this->endpoint,
        );
    }
}
