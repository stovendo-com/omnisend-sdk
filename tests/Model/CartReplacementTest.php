<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
 */

declare(strict_types=1);

namespace Stovendo\Omnisend\Tests\Model;

use PHPUnit\Framework\TestCase;
use Stovendo\Omnisend\Model\CartReplacement;
use Stovendo\Omnisend\Test\OmnisendFixtures;

/**
 * @covers \Stovendo\Omnisend\Model\CartReplacement
 */
class CartReplacementTest extends TestCase
{
    public function test_from_cart(): void
    {
        $cart = OmnisendFixtures::createCart();
        $cartReplacement = CartReplacement::fromCart($cart);

        $this->assertEquals($cart->cartID, $cartReplacement->cartID);
        $this->assertEquals($cart->currency, $cartReplacement->currency);
        $this->assertEquals($cart->cartSum, $cartReplacement->cartSum);
        $this->assertEquals($cart->products, $cartReplacement->products);
        $this->assertEquals($cart->cartRecoveryUrl, $cartReplacement->cartRecoveryUrl);
        $this->assertEquals($cart->createdAt, $cartReplacement->createdAt);
        $this->assertEquals($cart->updatedAt, $cartReplacement->updatedAt);
    }

    public function test_serialize_cart_replacement(): void
    {
        $cart = OmnisendFixtures::createCart();
        $cartReplacement = CartReplacement::fromCart($cart);

        $serialized = json_encode($cartReplacement, flags: \JSON_THROW_ON_ERROR);
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/data/cart_replacement.json', $serialized);
    }
}
