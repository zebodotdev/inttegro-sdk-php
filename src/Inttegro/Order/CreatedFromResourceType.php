<?php

namespace Inttegro\Order;

/**
 * Allowed wire values for order created from resource type.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum CreatedFromResourceType: string
{
    /**
     * Selects the `purchase_intent` API value for order created from resource type.
     *
     * Wire value: `purchase_intent`.
     */
    case PurchaseIntent = 'purchase_intent';
}
