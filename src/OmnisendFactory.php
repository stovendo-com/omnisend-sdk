<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
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
