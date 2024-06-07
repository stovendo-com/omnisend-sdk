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
use Webmozart\Assert\Assert;

class Cart
{
    /**
     * @param array<CartProduct> $products
     */
    public function __construct(
        public string $cartID,
        public string $currency,
        public int $cartSum,
        public ?string $contactID = null,
        public ?string $email = null,
        public ?string $phone = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
        public array $products = [],
        public ?string $cartRecoveryUrl = null
    ) {
        Assert::allNullOrIsInstanceOf($products, CartProduct::class);
        Assert::true($this->email !== null || $this->contactID !== null, 'Either email or contactId must be provided');
    }
}
