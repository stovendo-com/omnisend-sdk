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
 * @implements IteratorAggregate<int, Product>
 * @implements ArrayAccess<int, Product>
 */
class Products implements IteratorAggregate, Countable, ArrayAccess
{
    /**
     * @param array<Product> $products
     */
    public function __construct(
        public array $products,
    ) {
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->products);
    }

    public function count(): int
    {
        return count($this->products);
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->products[$offset]);
    }

    public function offsetGet(mixed $offset): Product
    {
        return $this->products[$offset];
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
