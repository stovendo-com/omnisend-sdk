<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
 */

declare(strict_types=1);

namespace Stovendo\Omnisend\Model;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use RuntimeException;
use Traversable;

/**
 * @implements IteratorAggregate<int, Order>
 * @implements ArrayAccess<int, Order>
 */
class Orders implements IteratorAggregate, Countable, ArrayAccess
{
    /**
     * @param array<Order> $orders
     */
    public function __construct(
        public array $orders,
    ) {
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->orders);
    }

    public function count(): int
    {
        return count($this->orders);
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->orders[$offset]);
    }

    public function offsetGet(mixed $offset): Order
    {
        return $this->orders[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new RuntimeException('Setting values is not allowed');
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new RuntimeException('Unsetting values is not allowed');
    }
}
