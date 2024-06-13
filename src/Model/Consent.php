<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
 */

declare(strict_types=1);

namespace Stovendo\Omnisend\Model;

use DateTimeImmutable;

class Consent
{
    public function __construct(
        public ?string $source,
        public ?string $ip,
        public ?string $userAgent,
        public ?DateTimeImmutable $createdAt = null,
    ) {
    }
}
