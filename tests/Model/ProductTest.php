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

namespace Stovendo\Omnisend\Tests\Model;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Stovendo\Omnisend\Model\ProductStatus;
use Stovendo\Omnisend\Test\OmnisendFixtures;

#[CoversClass(\Stovendo\Omnisend\Model\Product::class)] class ProductTest extends TestCase
{
    public function test_create(): void
    {
        $product = OmnisendFixtures::createProduct();

        $this->assertEquals('product-1', $product->productID);
        $this->assertEquals('Apple Juice', $product->title);
        $this->assertEquals(ProductStatus::IN_STOCK, $product->status);
    }
}
