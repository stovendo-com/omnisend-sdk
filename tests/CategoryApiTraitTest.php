<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
 */

declare(strict_types=1);

namespace Stovendo\Omnisend\Tests;

use PHPUnit\Framework\TestCase;
use Stovendo\Omnisend\Exception\InvalidArgumentException;
use Stovendo\Omnisend\Model\Categories;
use Stovendo\Omnisend\Trait\CategoryApiTrait;

class CategoryApiTraitTest extends TestCase
{
    public function test_get_categories_passes_query_parameters(): void
    {
        $client = new class() {
            use CategoryApiTrait;

            public array $args = [];
            private const ENDPOINT_CATEGORIES = '/categories';

            public function get(string $endpoint, string $expectedType, array $query = []): object
            {
                $this->args = [$endpoint, $expectedType, $query];
                return new Categories();
            }
        };

        $client->getCategories(5, 10);

        [$endpoint, $type, $query] = $client->args;
        $this->assertSame('/categories', $endpoint);
        $this->assertSame(Categories::class, $type);
        $this->assertSame(['offset' => 5, 'limit' => 10], $query);
    }

    public function test_get_categories_with_limit_over_250_throws_exception(): void
    {
        $client = new class() {
            use CategoryApiTrait;
            private const ENDPOINT_CATEGORIES = '/categories';

            public function get(string $endpoint, string $expectedType, array $query = []): object
            {
                return new Categories();
            }
        };

        $this->expectException(InvalidArgumentException::class);
        $client->getCategories(0, 251);
    }
}
