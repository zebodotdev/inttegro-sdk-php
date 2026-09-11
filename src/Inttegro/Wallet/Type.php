<?php

namespace Inttegro\Wallet;

/**
 * Allowed wire values for wallet type.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum Type: string
{
    /**
     * Selects the `mobile_money` API value for wallet type.
     *
     * Wire value: `mobile_money`.
     */
    case MobileMoney = 'mobile_money';
}
