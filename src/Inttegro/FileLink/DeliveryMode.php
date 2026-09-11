<?php

namespace Inttegro\FileLink;

/**
 * Allowed wire values for file link delivery mode.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum DeliveryMode: string
{
    /**
     * Selects the `redirect` API value for file link delivery mode.
     *
     * Wire value: `redirect`.
     */
    case Redirect = 'redirect';

    /**
     * Selects the `download` API value for file link delivery mode.
     *
     * Wire value: `download`.
     */
    case Download = 'download';

    /**
     * Selects the `inline` API value for file link delivery mode.
     *
     * Wire value: `inline`.
     */
    case Inline = 'inline';
}
