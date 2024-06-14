<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
 */

declare(strict_types=1);

namespace Stovendo\Omnisend\Model;

class Category
{
    public function __construct(
        public string $categoryID,
        public string $title,
    ) {
    }
}
