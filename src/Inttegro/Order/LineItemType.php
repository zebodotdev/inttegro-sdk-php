<?php

namespace Inttegro\Order;

/**
 * Type of line item.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum LineItemType: string
{
    /**
     * Selects the `product` API value for order line item type.
     *
     * Wire value: `product`.
     */
    case Product = 'product';

    /**
     * Selects the `fee` API value for order line item type.
     *
     * Wire value: `fee`.
     */
    case Fee = 'fee';

    /**
     * Selects the `shipping` API value for order line item type.
     *
     * Wire value: `shipping`.
     */
    case Shipping = 'shipping';
}
