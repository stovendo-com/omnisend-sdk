<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
 */

declare(strict_types=1);

namespace Stovendo\Omnisend\Model;

use Stovendo\Omnisend\OmnisendException;
use Symfony\Component\Serializer\Attribute\Ignore;
use Webmozart\Assert\Assert;

class ContactIdentifier
{
    public const TYPE_EMAIL = 'email';
    public const TYPE_PHONE = 'phone';

    /**
     * @param string $id This is either an email or phone number, depending on the type
     */
    public function __construct(
        public string $id,
        public string $type,
        public ContactIdentifierChannels $channels,
    ) {
        Assert::inArray($type, [self::TYPE_EMAIL, self::TYPE_PHONE]);

        if ($this->isPhone()) {
            Assert::notNull($this->channels->phone);
        }

        if ($this->isEmail()) {
            Assert::notNull($this->channels->email);
        }
    }

    #[Ignore]
    public function isEmail(): bool
    {
        return $this->type === self::TYPE_EMAIL;
    }

    #[Ignore]
    public function isPhone(): bool
    {
        return $this->type === self::TYPE_PHONE;
    }

    public function getEmailChannel(): ContactIdentifierChannel
    {
        if (!$this->isEmail()) {
            throw new OmnisendException('This identifier is not an email, therefore it does not have an email channel');
        }

        Assert::notNull($this->channels->email);

        return $this->channels->email;
    }

    /**
     * Quick constructor for email identifier.
     */
    public static function email(string $email, string $status = ContactIdentifierChannel::STATUS_SUBSCRIBED): self
    {
        return new self($email, self::TYPE_EMAIL, new ContactIdentifierChannels(email: new ContactIdentifierChannel($status)));
    }

    /**
     * Quick constructor for phone identifier.
     */
    public static function phone(string $phone, string $status = ContactIdentifierChannel::STATUS_SUBSCRIBED): self
    {
        return new self($phone, self::TYPE_PHONE, new ContactIdentifierChannels(phone: new ContactIdentifierChannel($status)));
    }
}
