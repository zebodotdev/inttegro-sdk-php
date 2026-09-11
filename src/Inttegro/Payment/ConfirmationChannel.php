<?php

namespace Inttegro\Payment;

/**
 * Channel used to send the token.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum ConfirmationChannel: string
{
    /**
     * Selects the `sms` API value for payment confirmation channel.
     *
     * Wire value: `sms`.
     */
    case Sms = 'sms';

    /**
     * Selects the `email` API value for payment confirmation channel.
     *
     * Wire value: `email`.
     */
    case Email = 'email';

    /**
     * Selects the `push` API value for payment confirmation channel.
     *
     * Wire value: `push`.
     */
    case Push = 'push';
}
