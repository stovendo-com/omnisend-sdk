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
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Webmozart\Assert\Assert;

class NewContact
{
    /**
     * @param array<ContactIdentifier> $identifiers
     * @param array<string>            $tags
     */
    public function __construct(
        public array $identifiers,
        public ?string $firstName = null,
        public ?string $lastName = null,
        public array $tags = [],
        public ?string $country = null,
        public ?string $countryCode = null,
        public ?string $state = null,
        public ?string $city = null,
        public ?string $address = null,
        public ?string $postalCode = null,
        public ?string $gender = null,
        #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
        public ?DateTimeImmutable $birthdate = null,
        public bool $sendWelcomeEmail = false,
    ) {
        Assert::nullOrInArray($gender, ['m', 'f']);
    }

    public static function withEmail(
        string $email,
        string $status = ContactIdentifierChannel::STATUS_SUBSCRIBED,
    ): self {
        return new self(
            identifiers: [
                new ContactIdentifier(
                    id: $email,
                    type: ContactIdentifier::TYPE_EMAIL,
                    channels: new ContactIdentifierChannels(
                        email: new ContactIdentifierChannel($status)
                    )
                ),
            ],
        );
    }
}
