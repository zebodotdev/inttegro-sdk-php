<?php

namespace Inttegro\Order;

/**
 * Hosted document that was delivered.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum DocumentKind: string
{
    /**
     * Selects the `invoice` API value for order document kind.
     *
     * Wire value: `invoice`.
     */
    case Invoice = 'invoice';

    /**
     * Selects the `receipt` API value for order document kind.
     *
     * Wire value: `receipt`.
     */
    case Receipt = 'receipt';
}
