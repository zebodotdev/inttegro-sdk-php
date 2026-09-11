<?php

namespace Inttegro\MessageTemplate;

/**
 * Delivery channel this template renders for.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum Channel: string
{
    /**
     * Selects the `sms` API value for message template channel.
     *
     * Wire value: `sms`.
     */
    case Sms = 'sms';

    /**
     * Selects the `email` API value for message template channel.
     *
     * Wire value: `email`.
     */
    case Email = 'email';
}
