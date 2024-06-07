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
