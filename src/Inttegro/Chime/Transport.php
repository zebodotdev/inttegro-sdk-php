<?php

namespace Inttegro\Chime;

/**
 * Allowed wire values for chime transport.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum Transport: string
{
    /**
     * Selects the `sms` API value for chime transport.
     *
     * Wire value: `sms`.
     */
    case Sms = 'sms';

    /**
     * Selects the `email` API value for chime transport.
     *
     * Wire value: `email`.
     */
    case Email = 'email';
}
