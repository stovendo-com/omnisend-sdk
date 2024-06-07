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

use Stovendo\Omnisend\Exception\OrderNotFoundException;
use Stovendo\Omnisend\Model\Order;

trait OrderApiTrait
{
    public function createOrder(Order $order): void
    {
        $this->post('/orders', $order);
    }

    public function replaceOrder(Order $order): void
    {
        $this->put('/orders/'.$order->orderID, $order);
    }

    public function upsertOrder(Order $order): void
    {
        $this->getOrder($order->orderID) ? $this->replaceOrder($order) : $this->createOrder($order);
    }

    public function getOrder(string $orderId): ?Order
    {
        try {
            return $this->get('/orders/'.$orderId, Order::class);
        } catch (OrderNotFoundException) {
            return null;
        }
    }
}
