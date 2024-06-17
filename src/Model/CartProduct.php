<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
 */

declare(strict_types=1);

namespace Stovendo\Omnisend\Model;

class CartProduct
{
    public function __construct(
        public string $cartProductID,
        public string $productID,
        public string $variantID,
        public string $title,
        public int $price,
        public int $quantity = 1,
        public ?string $sku = null,
        public ?string $description = null,
        public ?int $oldPrice = null,
        public ?int $discount = null,
        public ?string $imageUrl = null,
        public ?string $productUrl = null
    ) {
    }
}
