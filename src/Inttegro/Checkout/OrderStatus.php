<?php

namespace Inttegro\Checkout;

/**
 * Current status of the order.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum OrderStatus: string
{
    /**
     * Selects the `preparing` API value for checkout order status.
     *
     * Wire value: `preparing`.
     */
    case Preparing = 'preparing';

    /**
     * Selects the `requires_payment` API value for checkout order status.
     *
     * Wire value: `requires_payment`.
     */
    case RequiresPayment = 'requires_payment';

    /**
     * The operation reached its completed state.
     *
     * Wire value: `completed`.
     */
    case Completed = 'completed';

    /**
     * The operation was canceled before successful completion.
     *
     * Wire value: `canceled`.
     */
    case Canceled = 'canceled';

    /**
     * The value is no longer usable because its validity period ended.
     *
     * Wire value: `expired`.
     */
    case Expired = 'expired';
}
