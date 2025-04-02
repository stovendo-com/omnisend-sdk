<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
 */

declare(strict_types=1);

namespace Stovendo\Omnisend\Model;

use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Webmozart\Assert\Assert;

/**
 * Note: sending null values to Omnisend API will cause an error stating that only one channel can be provided.
 * That's why we're using AbstractObjectNormalizer::SKIP_NULL_VALUES to skip null values.
 */
class ContactIdentifierChannels
{
    public function __construct(
        #[Context(context: [AbstractObjectNormalizer::SKIP_NULL_VALUES => true])]
        public ?ContactIdentifierChannel $email = null,
        #[Context(context: [AbstractObjectNormalizer::SKIP_NULL_VALUES => true])]
        public ?ContactIdentifierChannel $sms = null,
    ) {
        Assert::false($email === null && $sms === null, 'At least one channel must be provided');
    }
}
