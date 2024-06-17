<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
 */

declare(strict_types=1);

namespace Stovendo\Omnisend\Model;

use DateTimeImmutable;
use Webmozart\Assert\Assert;

class CartReplacement
{
    /**
     * @param array<CartProduct> $products
     */
    public function __construct(
        public string $cartID,
        public string $currency,
        public int $cartSum,
        public array $products = [],
        public ?string $cartRecoveryUrl = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
    ) {
        Assert::allNullOrIsInstanceOf($products, CartProduct::class);
    }

    public static function fromCart(Cart $cart): self
    {
        return new self(
            cartID: $cart->cartID,
            currency: $cart->currency,
            cartSum: $cart->cartSum,
            products: $cart->products,
            cartRecoveryUrl: $cart->cartRecoveryUrl,
            createdAt: $cart->createdAt,
            updatedAt: $cart->updatedAt,
        );
    }
}
