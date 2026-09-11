<?php

namespace Inttegro\PurchaseIntent;

/**
 * Allowed wire values for purchase intent activity type.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum ActivityType: string
{
    /**
     * Selects the `expired_viewed` API value for purchase intent activity type.
     *
     * Wire value: `expired_viewed`.
     */
    case ExpiredViewed = 'expired_viewed';

    /**
     * Selects the `order_created` API value for purchase intent activity type.
     *
     * Wire value: `order_created`.
     */
    case OrderCreated = 'order_created';

    /**
     * Selects the `payment_failed` API value for purchase intent activity type.
     *
     * Wire value: `payment_failed`.
     */
    case PaymentFailed = 'payment_failed';

    /**
     * Selects the `payment_started` API value for purchase intent activity type.
     *
     * Wire value: `payment_started`.
     */
    case PaymentStarted = 'payment_started';

    /**
     * Selects the `viewed` API value for purchase intent activity type.
     *
     * Wire value: `viewed`.
     */
    case Viewed = 'viewed';
}
