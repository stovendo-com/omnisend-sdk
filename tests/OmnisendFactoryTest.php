<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
 */

declare(strict_types=1);

namespace Stovendo\Omnisend\Tests;

use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Stovendo\Omnisend\OmnisendApiClient;
use Stovendo\Omnisend\OmnisendFactory;

/**
 * @covers \Stovendo\Omnisend\OmnisendFactory
 */
class OmnisendFactoryTest extends TestCase
{
    public function test_create(): void
    {
        $httpClient = $this->createMock(ClientInterface::class);
        $omnisendFactory = new OmnisendFactory($httpClient);
        $omnisend = $omnisendFactory->create('test');

        $this->assertInstanceOf(OmnisendApiClient::class, $omnisend);
    }
}
