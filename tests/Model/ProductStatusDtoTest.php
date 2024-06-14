<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
 */

declare(strict_types=1);

namespace Stovendo\Omnisend\Tests\Model;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Stovendo\Omnisend\Model\ProductStatus;

#[CoversClass(ProductStatus::class)] class ProductStatusDtoTest extends TestCase
{
    public function test_json_serialize(): void
    {
        $productStatusDto = ProductStatus::IN_STOCK;
        $this->assertEquals('inStock', $productStatusDto->jsonSerialize());

        $productStatusDto = ProductStatus::OUT_OF_STOCK;
        $this->assertEquals('outOfStock', $productStatusDto->jsonSerialize());

        $productStatusDto = ProductStatus::NOT_AVAILABLE;
        $this->assertEquals('notAvailable', $productStatusDto->jsonSerialize());
    }
}
