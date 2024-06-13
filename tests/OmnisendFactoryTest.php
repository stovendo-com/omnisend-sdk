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
