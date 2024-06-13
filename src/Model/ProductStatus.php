<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
 */

declare(strict_types=1);

namespace Stovendo\Omnisend\Model;

use JsonSerializable;

enum ProductStatus: string implements JsonSerializable
{
    case IN_STOCK = 'inStock';
    case OUT_OF_STOCK = 'outOfStock';
    case NOT_AVAILABLE = 'notAvailable';

    public function jsonSerialize(): string
    {
        return $this->value;
    }
}
