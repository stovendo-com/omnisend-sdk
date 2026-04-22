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

    public function subscribeEmail(?DateTimeImmutable $statusDate = null): void
    {
        $this->setEmailSubscriptionStatus(ContactIdentifierChannel::STATUS_SUBSCRIBED, $statusDate);
    }

    public function unsubscribeEmail(?DateTimeImmutable $statusDate = null): void
    {
        $this->setEmailSubscriptionStatus(ContactIdentifierChannel::STATUS_UNSUBSCRIBED, $statusDate);
    }

    public function resetEmailSubscriptionStatus(?DateTimeImmutable $statusDate = null): void
    {
        $this->setEmailSubscriptionStatus(ContactIdentifierChannel::STATUS_NON_SUBSCRIBED, $statusDate);
    }

    #[Ignore]
    public function setEmailSubscriptionStatus(string $status, ?DateTimeImmutable $statusDate = null): void
    {
        $this->getEmailIdentifier()->getEmailChannel()->status = $status;
        $this->getEmailIdentifier()->getEmailChannel()->statusDate = $statusDate ?? new DateTimeImmutable();
    }

    #[Ignore]
    public function getEmail(): ?string
    {
        return $this->getEmailIdentifier()->id;
    }

    #[Ignore]
    public function setEmail(string $email): void
    {
        $this->getEmailIdentifier()->id = $email;
    }

    public function subscribePhone(?DateTimeImmutable $statusDate = null): void
    {
        $this->setPhoneSubscriptionStatus(ContactIdentifierChannel::STATUS_SUBSCRIBED, $statusDate);
    }

    public function unsubscribePhone(?DateTimeImmutable $statusDate = null): void
    {
        $this->setPhoneSubscriptionStatus(ContactIdentifierChannel::STATUS_UNSUBSCRIBED, $statusDate);
    }

    public function resetPhoneSubscriptionStatus(?DateTimeImmutable $statusDate = null): void
    {
        $this->setPhoneSubscriptionStatus(ContactIdentifierChannel::STATUS_NON_SUBSCRIBED, $statusDate);
    }

    #[Ignore]
    public function setPhoneSubscriptionStatus(string $status, ?DateTimeImmutable $statusDate = null): void
    {
        $this->getPhoneIdentifierOrFail()->getPhoneChannel()->status = $status;
        $this->getPhoneIdentifierOrFail()->getPhoneChannel()->statusDate = $statusDate ?? new DateTimeImmutable();
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
