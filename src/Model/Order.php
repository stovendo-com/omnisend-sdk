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

class Order
{
    /**
     * Payment awaiting payment.
     */
    public const string STATUS_AWAITING_PAYMENT = 'awaitingPayment';

    /**
     * Payment partially paid.
     */
    public const string STATUS_PARTIALLY_PAID = 'partiallyPaid';

    /**
     * Payment paid.
     */
    public const string STATUS_PAID = 'paid';

    /**
     * Payment partially refunded.
     */
    public const string STATUS_PARTIALLY_REFUNDED = 'partiallyRefunded';

    /**
     * Payment refunded.
     */
    public const string STATUS_REFUNDED = 'refunded';

    /**
     * Payment canceled.
     */
    public const string STATUS_VOIDED = 'voided';

    /**
     * Order placed.
     */
    public const string FULFILLMENT_STATUS_UNFULFILLED = 'unfulfilled';

    /**
     * Order in progress.
     */
    public const string FULFILLMENT_STATUS_IN_PROGRESS = 'inProgress';

    /**
     * Order prepared for pickup (if delivery type pickup selected) or shipped.
     */
    public const string FULFILLMENT_STATUS_FULFILLED = 'fulfilled';

    /**
     * Order has been picked up by or delivered to customer.
     */
    public const string FULFILLMENT_STATUS_DELIVERED = 'delivered';

    /**
     * Restocked.
     */
    public const string FULFILLMENT_STATUS_RESTOCKED = 'restocked';

    /**
     * @param array<OrderItemProduct> $orderItems
     */
    public function __construct(
        public string $orderID,
        public string $email,
        public int $orderNumber,
        public string $currency,
        public int $orderSum,
        public DateTimeImmutable $createdAt,
        public ?string $paymentStatus = self::STATUS_AWAITING_PAYMENT,
        public ?string $fulfillmentStatus = self::FULFILLMENT_STATUS_UNFULFILLED,
        public ?array $orderItems = [],
    ) {
    }
}
