<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
 */

declare(strict_types=1);

namespace Stovendo\Omnisend\Trait;

use Stovendo\Omnisend\Exception\CartNotFoundException;
use Stovendo\Omnisend\Model\Cart;
use Stovendo\Omnisend\Model\CartProduct;
use Stovendo\Omnisend\Model\CartReplacement;
use Stovendo\Omnisend\Model\CartUpdate;

trait CartApiTrait
{
    public function getCart(string $cartId): ?Cart
    {
        try {
            return $this->get('/carts/'.$cartId, Cart::class);
        } catch (CartNotFoundException) {
            return null;
        }
    }

    public function createCart(Cart $cart): void
    {
        $this->sendRequest('POST', '/carts', $cart);
    }

    public function updateCart(Cart|CartUpdate $cart): void
    {
        $update = CartUpdate::fromCart($cart);
        $this->sendRequest('PATCH', '/carts/'.$update->cartID, $update);
    }

    public function upsertCart(Cart $cart): void
    {
        $this->getCart($cart->cartID) ? $this->replaceCart($cart) : $this->createCart($cart);
    }

    public function replaceCart(Cart|CartReplacement $cart): void
    {
        if ($cart instanceof Cart) {
            $cart = CartReplacement::fromCart($cart);
        }

        $this->sendRequest('PUT', '/carts/'.$cart->cartID, $cart);
    }

    public function deleteCart(string|Cart $cart): void
    {
        try {
            $cartId = $cart instanceof Cart ? $cart->cartID : $cart;
            $this->sendRequest('DELETE', '/carts/'.$cartId);
        } catch (CartNotFoundException) {
            // Cart already deleted
        }
    }

    public function addProductToCart(string $cartId, CartProduct $cartProduct): void
    {
        $this->sendRequest('POST', '/carts/'.$cartId.'/products', $cartProduct);
    }

    public function removeProductFromCart(string $cartId, string $cartProductId): void
    {
        $this->sendRequest('DELETE', '/carts/'.$cartId.'/products/'.$cartProductId);
    }
}
