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

namespace Stovendo\Omnisend\Model;

class OrderItemProduct
{
    /**
     * @param array<string> $categoryIDs
     */
    public function __construct(
        public string $productID,
        public string $sku,
        public string $variantID,
        public string $variantTitle,
        public string $title,
        public int $price,
        public int $quantity = 1,
        public ?string $imageUrl = null,
        public ?string $productUrl = null,
        public ?array $categoryIDs = []
    ) {
    }
}
