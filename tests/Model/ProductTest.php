<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
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
