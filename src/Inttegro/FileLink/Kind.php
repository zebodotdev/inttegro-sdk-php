<?php

namespace Inttegro\FileLink;

/**
 * Allowed wire values for file link kind.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum Kind: string
{
    /**
     * Selects the `public` API value for file link kind.
     *
     * Wire value: `public`.
     */
    case PublicLink = 'public';
}
