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
 * @implements IteratorAggregate<int, Category>
 * @implements ArrayAccess<int, Category>
 */
class Categories implements IteratorAggregate, Countable, ArrayAccess
{
    /**
     * @param array<Category> $categories
     */
    public function __construct(
        public array $categories,
    ) {
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->categories);
    }

    public function count(): int
    {
        return count($this->categories);
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->categories[$offset]);
    }

    public function offsetGet(mixed $offset): Category
    {
        return $this->categories[$offset];
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
