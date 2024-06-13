<?php

/**
 * @copyright © UAB NFQ Technologies
 *
 * This Software is the property of NFQ Technologies
 * and is protected by copyright law – it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license key
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * Contact UAB NFQ Technologies:
 * E-mail: info@nfq.lt
 * https://www.nfq.lt
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
    public const STATUS_SUBSCRIBED = 'subscribed';
    public const STATUS_UNSUBSCRIBED = 'unsubscribed';
    public const STATUS_NON_SUBSCRIBED = 'nonSubscribed';

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
