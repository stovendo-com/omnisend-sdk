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

/**
 * Note: It seems that there is some inconsistency in the API documentation.
 * When adding product currency is required, but when getting the cart, it is coming back as null.
 */
class CartProduct
{
    public function __construct(
        public string $cartProductID,
        public string $productID,
        public string $variantID,
        public string $title,
        public int $price,
        public int $quantity = 1,
        public ?string $currency = null,
        public ?string $sku = null,
        public ?string $description = null,
        public ?int $oldPrice = null,
        public ?int $discount = null,
        public ?string $imageUrl = null,
        public ?string $productUrl = null
    ) {
    }
}