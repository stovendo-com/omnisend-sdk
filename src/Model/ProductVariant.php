<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
 */

declare(strict_types=1);

namespace Stovendo\Omnisend\Model;

class ProductVariant
{
    /**
     * @param int     $price      In cents
     * @param ?int    $oldPrice   In cents
     * @param ?string $productUrl Link to product page
     */
    public function __construct(
        public string $variantID,
        public string $title,
        public ProductStatus $status,
        public int $price,
        public ?string $sku = null,
        public ?int $oldPrice = null,
        public ?string $productUrl = null,
        public ?string $imageID = null,
    ) {
    }
}
