<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
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
