<?php

namespace Inttegro\SecretKey;

/**
 * Allowed wire values for secret key token type.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum TokenType: string
{
    /**
     * Selects the `bearer` API value for secret key token type.
     *
     * Wire value: `bearer`.
     */
    case Bearer = 'bearer';
}
