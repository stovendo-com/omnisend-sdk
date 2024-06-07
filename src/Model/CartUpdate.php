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

use Webmozart\Assert\Assert;

class CartUpdate
{
    /**
     * @param array<CartProduct> $products
     */
    public function __construct(
        public string $cartID,
        public string $currency,
        public int $cartSum,
        public array $products = [],
        public ?string $cartRecoveryUrl = null
    ) {
        Assert::allNullOrIsInstanceOf($products, CartProduct::class);
    }

    public static function fromCart(Cart|self $cart): self
    {
        if ($cart instanceof self) {
            return $cart;
        }

        return new self(
            cartID: $cart->cartID,
            currency: $cart->currency,
            cartSum: $cart->cartSum,
            products: $cart->products,
            cartRecoveryUrl: $cart->cartRecoveryUrl
        );
    }
}
