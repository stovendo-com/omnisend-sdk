<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
 */

declare(strict_types=1);

namespace Stovendo\Omnisend\Exception;

use Stovendo\Omnisend\OmnisendException;

class ProductAlreadyInCartException extends OmnisendException
{
    public function __construct()
    {
        parent::__construct('Product is already in cart.');
    }
}
