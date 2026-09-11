<?php

namespace Inttegro\Money;

/**
 * A currency code recognized by the Inttegro API. Individual operations can support a subset of these currencies.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum Currency: string
{
    /**
     * Ghanaian cedi (GHS).
     *
     * Wire value: `ghs`.
     */
    case GHS = 'ghs';

    /**
     * United States dollar (USD).
     *
     * Wire value: `usd`.
     */
    case USD = 'usd';

    /**
     * Pound sterling (GBP).
     *
     * Wire value: `gbp`.
     */
    case GBP = 'gbp';

    /**
     * Euro (EUR).
     *
     * Wire value: `eur`.
     */
    case EUR = 'eur';

    /**
     * Chinese yuan (CNY).
     *
     * Wire value: `cny`.
     */
    case CNY = 'cny';
}
