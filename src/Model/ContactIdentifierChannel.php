<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
 */

declare(strict_types=1);

namespace Stovendo\Omnisend\Model;

use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Webmozart\Assert\Assert;

#[Context(context: [AbstractObjectNormalizer::SKIP_NULL_VALUES => false])]
class ContactIdentifierChannel
{
    public const string STATUS_SUBSCRIBED = 'subscribed';
    public const string STATUS_UNSUBSCRIBED = 'unsubscribed';
    public const string STATUS_NON_SUBSCRIBED = 'nonSubscribed';

    public function __construct(
        public string $status,
        public ?DateTimeImmutable $statusDate = null
    ) {
        Assert::oneOf($status, [
            self::STATUS_SUBSCRIBED,
            self::STATUS_UNSUBSCRIBED,
            self::STATUS_NON_SUBSCRIBED,
        ], 'Invalid status');
    }
}
