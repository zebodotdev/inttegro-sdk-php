<?php

namespace Inttegro\BalanceTransaction;

/**
 * Semantic source or cause of this entry, not its direction.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum Type: string
{
    /**
     * Selects the `payment` API value for balance transaction type.
     *
     * Wire value: `payment`.
     */
    case Payment = 'payment';

    /**
     * Selects the `refund` API value for balance transaction type.
     *
     * Wire value: `refund`.
     */
    case Refund = 'refund';
}
