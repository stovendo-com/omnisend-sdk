<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
 */

declare(strict_types=1);

namespace Stovendo\Omnisend\Model;

use DateTimeImmutable;
use Stovendo\Omnisend\OmnisendException;
use Symfony\Component\Serializer\Attribute\Ignore;

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

    #[Ignore]
    public function setEmailSubscriptionStatus(string $status): void
    {
        $this->getEmailIdentifier()->getEmailChannel()->status = $status;
    }

    public function subscribePhone(): void
    {
        $this->getPhoneIdentifierOrFail()->getPhoneChannel()->status = ContactIdentifierChannel::STATUS_SUBSCRIBED;
    }

    public function unsubscribePhone(): void
    {
        $this->getPhoneIdentifierOrFail()->getPhoneChannel()->status = ContactIdentifierChannel::STATUS_UNSUBSCRIBED;
    }

    public function resetPhoneSubscriptionStatus(): void
    {
        $this->getPhoneIdentifierOrFail()->getPhoneChannel()->status = ContactIdentifierChannel::STATUS_NON_SUBSCRIBED;
    }

    #[Ignore]
    public function setPhoneSubscriptionStatus(string $status): void
    {
        $this->getPhoneIdentifierOrFail()->getPhoneChannel()->status = $status;
    }

    #[Ignore]
    public function getPhone(): ?string
    {
        return $this->getPhoneIdentifier()?->id;
    }

    #[Ignore]
    public function setPhone(string $phone): void
    {
        $phoneIdentifier = $this->getPhoneIdentifier();

        if ($phoneIdentifier) {
            $phoneIdentifier->id = $phone;
        } else {
            $this->identifiers[] = ContactIdentifier::phone(
                $phone,
                ContactIdentifierChannel::STATUS_NON_SUBSCRIBED,
            );
        }
    }

    #[Ignore]
    private function getEmailIdentifier(): ContactIdentifier
    {
        foreach ($this->identifiers as $identifier) {
            if ($identifier->isEmail()) {
                return $identifier;
            }
        }

        throw new OmnisendException('Contact does not have an email identifier');
    }

    #[Ignore]
    private function getPhoneIdentifier(): ?ContactIdentifier
    {
        foreach ($this->identifiers as $identifier) {
            if ($identifier->isPhone()) {
                return $identifier;
            }
        }

        return null;
    }

    #[Ignore]
    private function getPhoneIdentifierOrFail(): ContactIdentifier
    {
        return $this->getPhoneIdentifier() ?? throw new OmnisendException('Contact does not have a phone identifier');
    }
}
