<?php

namespace Inttegro\PaymentMethod;

/**
 * Allowed wire values for payment method mobile money network.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum MobileMoneyNetwork: string
{
    /**
     * Selects the `airtel` API value for payment method mobile money network.
     *
     * Wire value: `airtel`.
     */
    case Airtel = 'airtel';

    /**
     * Selects the `mtn` API value for payment method mobile money network.
     *
     * Wire value: `mtn`.
     */
    case MTN = 'mtn';

    /**
     * Selects the `telecel` API value for payment method mobile money network.
     *
     * Wire value: `telecel`.
     */
    case Telecel = 'telecel';

    /**
     * Selects the `vodafone` API value for payment method mobile money network.
     *
     * Wire value: `vodafone`.
     */
    case Vodafone = 'vodafone';
}
