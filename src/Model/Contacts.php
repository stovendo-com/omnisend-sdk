<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
 */

declare(strict_types=1);

namespace Stovendo\Omnisend\Model;

class Contacts
{
    /**
     * @param array<Contact> $contacts
     */
    public function __construct(public array $contacts = [])
    {
    }

    public function first(): ?Contact
    {
        return $this->contacts[0] ?? null;
    }
}
