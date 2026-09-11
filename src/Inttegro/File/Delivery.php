<?php

namespace Inttegro\File;

/**
 * Allowed wire values for file delivery.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum Delivery: string
{
    /**
     * Selects the `stream` API value for file delivery.
     *
     * Wire value: `stream`.
     */
    case Stream = 'stream';

    /**
     * Selects the `redirect` API value for file delivery.
     *
     * Wire value: `redirect`.
     */
    case Redirect = 'redirect';
}
