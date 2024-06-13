<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
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
