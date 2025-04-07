<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
 */

declare(strict_types=1);

namespace Stovendo\Omnisend\Model;

use Webmozart\Assert\Assert;

class CustomEvent
{
    /**
     * @param string                     $systemName Event system name
     * @param null|string                $name       Event name
     * @param null|string                $email      Email or phone number is required
     * @param null|string                $phone      Email or phone number is required
     * @param null|array<string, string> $fields     Event custom fields
     */
    public function __construct(
        public string $systemName,
        public ?string $name = null,
        public ?string $email = null,
        public ?string $phone = null,
        public ?array $fields = null,
    ) {
        Assert::true($this->email !== null || $this->phone !== null, 'Either email or phone must be provided');
    }
}
