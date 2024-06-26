<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
 */

declare(strict_types=1);

namespace Stovendo\Omnisend\Model;

use DateTimeImmutable;
use Webmozart\Assert\Assert;

class Product
{
    /**
     * @param string                $currency    ISO currency code
     * @param null|string           $productUrl  Link to product page
     * @param null|string           $vendor      Product's vendor
     * @param null|string           $type        A categorization that a product can be tagged with, commonly used for filtering and searching. For example: book, virtualGood, music. It's not product category.
     * @param null|array<string>    $tags
     * @param array<string>         $categoryIDs
     * @param array<ProductImage>   $images
     * @param array<ProductVariant> $variants
     */
    public function __construct(
        public string $productID,
        public string $title,
        public ProductStatus $status,
        public string $description,
        public string $currency,
        public DateTimeImmutable $updatedAt,
        public ?string $productUrl = null,
        public ?string $vendor = null,
        public ?string $type = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?array $tags = [],
        public array $categoryIDs = [],
        public array $images = [],
        public array $variants = [],
    ) {
        Assert::minCount($this->variants, 1, 'Product must have at least one variant');

        if ($tags === null) {
            $this->tags = [];
        }
    }
}
