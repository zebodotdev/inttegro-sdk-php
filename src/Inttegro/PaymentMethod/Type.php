<?php

namespace Inttegro\PaymentMethod;

/**
 * Allowed wire values for payment method type.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum Type: string
{
    /**
     * Selects the `mobile_money` API value for payment method type.
     *
     * Wire value: `mobile_money`.
     */
    case MobileMoney = 'mobile_money';

    /**
     * Selects the `bank_account` API value for payment method type.
     *
     * Wire value: `bank_account`.
     */
    case BankAccount = 'bank_account';

    /**
     * Selects the `card` API value for payment method type.
     *
     * Wire value: `card`.
     */
    case Card = 'card';

    /**
     * Selects the `motito` API value for payment method type.
     *
     * Wire value: `motito`.
     */
    case Motito = 'motito';
}
