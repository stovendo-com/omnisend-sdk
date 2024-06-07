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
