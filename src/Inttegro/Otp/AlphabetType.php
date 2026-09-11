<?php

namespace Inttegro\Otp;

/**
 * Predefined alphabet type (mutually exclusive with token_alphabet).
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum AlphabetType: string
{
    /**
     * Selects the `numeric` API value for otp alphabet type.
     *
     * Wire value: `numeric`.
     */
    case Numeric = 'numeric';

    /**
     * Selects the `alpha` API value for otp alphabet type.
     *
     * Wire value: `alpha`.
     */
    case Alpha = 'alpha';

    /**
     * Selects the `alphanumeric` API value for otp alphabet type.
     *
     * Wire value: `alphanumeric`.
     */
    case Alphanumeric = 'alphanumeric';
}
