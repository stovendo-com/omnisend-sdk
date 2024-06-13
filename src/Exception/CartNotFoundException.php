<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
 */

declare(strict_types=1);

namespace Stovendo\Omnisend\Exception;

use Stovendo\Omnisend\OmnisendException;

class CartNotFoundException extends OmnisendException
{
    public function __construct()
    {
        parent::__construct('Cart not found');
    }
}
