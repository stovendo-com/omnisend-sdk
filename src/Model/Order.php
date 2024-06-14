<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
 */

declare(strict_types=1);

namespace Stovendo\Omnisend\Model;

use DateTimeImmutable;

class Order
{
    /**
     * Payment awaiting payment.
     */
    public const STATUS_AWAITING_PAYMENT = 'awaitingPayment';

    /**
     * Payment partially paid.
     */
    public const STATUS_PARTIALLY_PAID = 'partiallyPaid';

    /**
     * Payment paid.
     */
    public const STATUS_PAID = 'paid';

    /**
     * Payment partially refunded.
     */
    public const STATUS_PARTIALLY_REFUNDED = 'partiallyRefunded';

    /**
     * Payment refunded.
     */
    public const STATUS_REFUNDED = 'refunded';

    /**
     * Payment canceled.
     */
    public const STATUS_VOIDED = 'voided';

    /**
     * Order placed.
     */
    public const FULFILLMENT_STATUS_UNFULFILLED = 'unfulfilled';

    /**
     * Order in progress.
     */
    public const FULFILLMENT_STATUS_IN_PROGRESS = 'inProgress';

    /**
     * Order prepared for pickup (if delivery type pickup selected) or shipped.
     */
    public const FULFILLMENT_STATUS_FULFILLED = 'fulfilled';

    /**
     * Order has been picked up by or delivered to customer.
     */
    public const FULFILLMENT_STATUS_DELIVERED = 'delivered';

    /**
     * Restocked.
     */
    public const FULFILLMENT_STATUS_RESTOCKED = 'restocked';

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
