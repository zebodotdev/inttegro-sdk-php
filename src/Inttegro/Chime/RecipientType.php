<?php

namespace Inttegro\Chime;

/**
 * Contact type.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum RecipientType: string
{
    /**
     * Selects the `phone` API value for chime recipient type.
     *
     * Wire value: `phone`.
     */
    case Phone = 'phone';

    /**
     * Selects the `email` API value for chime recipient type.
     *
     * Wire value: `email`.
     */
    case Email = 'email';
}
