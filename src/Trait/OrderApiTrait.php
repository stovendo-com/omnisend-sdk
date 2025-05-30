<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
 */

declare(strict_types=1);

namespace Stovendo\Omnisend\Trait;

use Stovendo\Omnisend\Exception\InvalidArgumentException;
use Stovendo\Omnisend\Exception\OrderNotFoundException;
use Stovendo\Omnisend\Model\Order;
use Stovendo\Omnisend\Model\Orders;

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

    public function getOrders(int $offset = 0, int $limit = 250): Orders
    {
        if ($limit > 250) {
            throw new InvalidArgumentException('Limit cannot be greater than 250');
        }

        return $this->get('/orders', Orders::class, ['offset' => $offset, 'limit' => $limit]);
    }

    public function deleteOrder(string $orderId): void
    {
        try {
            $this->delete('/orders', $orderId);
        } catch (OrderNotFoundException) {
            // if it's not there, ignore it
        }
    }
}
