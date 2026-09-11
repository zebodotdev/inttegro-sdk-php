<?php

namespace Inttegro\BankAccount;

/**
 * Allowed wire values for bank account type.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum Type: string
{
    /**
     * Selects the `ghana_bank_account` API value for bank account type.
     *
     * Wire value: `ghana_bank_account`.
     */
    case GhanaBankAccount = 'ghana_bank_account';
}
