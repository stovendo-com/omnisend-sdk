<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
 */

declare(strict_types=1);

namespace Stovendo\Omnisend\Model;

class ProductImage
{
    /**
     * @param array<string> $variantIDs
     */
    public function __construct(
        public string $imageID,
        public ?string $url,
        public ?bool $isDefault = false,
        public array $variantIDs = []
    ) {
    }
}
