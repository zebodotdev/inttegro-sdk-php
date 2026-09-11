<?php

namespace Inttegro\FinancialAccount;

/**
 * Type of financial account.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum Type: string
{
    /**
     * Selects the `wallet` API value for financial account type.
     *
     * Wire value: `wallet`.
     */
    case Wallet = 'wallet';

    /**
     * Selects the `bank_account` API value for financial account type.
     *
     * Wire value: `bank_account`.
     */
    case BankAccount = 'bank_account';

    /**
     * Selects the `dosh_account` API value for financial account type.
     *
     * Wire value: `dosh_account`.
     */
    case DoshAccount = 'dosh_account';
}
