<?php

namespace Inttegro\Order;

/**
 * Delivery channel.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum DeliveryChannel: string
{
    /**
     * Selects the `email` API value for order delivery channel.
     *
     * Wire value: `email`.
     */
    case Email = 'email';

    /**
     * Selects the `sms` API value for order delivery channel.
     *
     * Wire value: `sms`.
     */
    case Sms = 'sms';
}
