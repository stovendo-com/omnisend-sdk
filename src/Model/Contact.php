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
use Stovendo\Omnisend\OmnisendException;

class Contact
{
    /**
     * @var array<Consent>
     */
    public array $consents;

    /**
     * @param array<ContactIdentifier> $identifiers
     * @param null|array<string>       $tags
     * @param null|array<Consent>      $consents
     */
    public function __construct(
        public string $contactID,
        public array $identifiers,
        public ?DateTimeImmutable $createdAt = null,
        public string $firstName = '',
        public string $lastName = '',
        public ?array $tags = [],
        public ?string $country = null,
        public ?string $countryCode = null,
        public ?string $state = null,
        public ?string $city = null,
        public ?string $address = null,
        public ?string $postalCode = null,
        public ?string $gender = null,
        public ?string $birthdate = null,
        ?array $consents = [],
    ) {
        /**
         * We need to adjust what was received from the api as it returns, for example,
         * null gender property as empty string; then when using such object
         * api complains that it is an empty string.
         */
        $this->consents = $consents ?? [];
        $this->tags = $tags ?? [];
        $this->gender = $gender !== '' ? $gender : null;
        $this->birthdate = $birthdate !== '' ? $birthdate : null;
    }

    public function subscribeEmail(): void
    {
        $this->getEmailIdentifier()->getEmailChannel()->status = ContactIdentifierChannel::STATUS_SUBSCRIBED;
    }

    public function unsubscribeEmail(): void
    {
        $this->getEmailIdentifier()->getEmailChannel()->status = ContactIdentifierChannel::STATUS_UNSUBSCRIBED;
    }

    public function resetEmailSubscriptionStatus(): void
    {
        $this->getEmailIdentifier()->getEmailChannel()->status = ContactIdentifierChannel::STATUS_NON_SUBSCRIBED;
    }

    public function setEmailSubscriptionStatus(string $status): void
    {
        $this->getEmailIdentifier()->getEmailChannel()->status = $status;
    }

    private function getEmailIdentifier(): ContactIdentifier
    {
        $identifier = array_filter($this->identifiers, fn (ContactIdentifier $identifier) => $identifier->isEmail())[0] ?? null;

        return $identifier ?? throw new OmnisendException('Contact does not have an email identifier');
    }
}
