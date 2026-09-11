<?php

namespace Inttegro\Refund;

/**
 * Allowed wire values for refund reason.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum Reason: string
{
    /**
     * Selects the `requested_by_customer` API value for refund reason.
     *
     * Wire value: `requested_by_customer`.
     */
    case RequestedByCustomer = 'requested_by_customer';

    /**
     * Selects the `duplicate` API value for refund reason.
     *
     * Wire value: `duplicate`.
     */
    case Duplicate = 'duplicate';

    /**
     * Selects the `fraudulent` API value for refund reason.
     *
     * Wire value: `fraudulent`.
     */
    case Fraudulent = 'fraudulent';

    /**
     * Selects the `order_canceled` API value for refund reason.
     *
     * Wire value: `order_canceled`.
     */
    case OrderCanceled = 'order_canceled';

    /**
     * Selects the `item_returned` API value for refund reason.
     *
     * Wire value: `item_returned`.
     */
    case ItemReturned = 'item_returned';

    /**
     * Selects the `item_damaged` API value for refund reason.
     *
     * Wire value: `item_damaged`.
     */
    case ItemDamaged = 'item_damaged';

    /**
     * Selects the `item_not_received` API value for refund reason.
     *
     * Wire value: `item_not_received`.
     */
    case ItemNotReceived = 'item_not_received';

    /**
     * Selects the `item_not_as_described` API value for refund reason.
     *
     * Wire value: `item_not_as_described`.
     */
    case ItemNotAsDescribed = 'item_not_as_described';

    /**
     * Identifies an application-defined variant.
     *
     * Wire value: `custom`.
     */
    case Custom = 'custom';
}
