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

namespace Stovendo\Omnisend\Trait;

use Stovendo\Omnisend\Exception\CartNotFoundException;
use Stovendo\Omnisend\Model\Cart;
use Stovendo\Omnisend\Model\CartProduct;
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

    public function addProductToCart(string $cartId, CartProduct $cartProduct): void
    {
        $this->sendRequest('POST', '/carts/'.$cartId.'/products', $cartProduct);
    }

    public function removeProductFromCart(string $cartId, string $cartProductId): void
    {
        $this->sendRequest('DELETE', '/carts/'.$cartId.'/products/'.$cartProductId);
    }
}
