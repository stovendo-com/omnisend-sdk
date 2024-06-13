<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
 */

declare(strict_types=1);

namespace Stovendo\Omnisend\Exception;

use Stovendo\Omnisend\OmnisendException;

class ContactNotFoundException extends OmnisendException
{
    public function __construct(string $message = 'Contact not found')
    {
        parent::__construct($message);
    }
}
