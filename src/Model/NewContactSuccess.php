<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
 */

declare(strict_types=1);

namespace Stovendo\Omnisend\Model;

class NewContactSuccess
{
    public string $contactID;

    public function __construct(string $contactID)
    {
        $this->contactID = $contactID;
    }
}
