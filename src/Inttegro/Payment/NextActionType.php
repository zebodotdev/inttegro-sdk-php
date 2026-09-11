<?php

namespace Inttegro\Payment;

/**
 * Type of action required.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum NextActionType: string
{
    /**
     * Selects the `confirm_payment` API value for payment next action type.
     *
     * Wire value: `confirm_payment`.
     */
    case ConfirmPayment = 'confirm_payment';

    /**
     * Selects the `execute` API value for payment next action type.
     *
     * Wire value: `execute`.
     */
    case Execute = 'execute';

    /**
     * Selects the `redirect` API value for payment next action type.
     *
     * Wire value: `redirect`.
     */
    case Redirect = 'redirect';

    /**
     * Selects the `authorize` API value for payment next action type.
     *
     * Wire value: `authorize`.
     */
    case Authorize = 'authorize';

    /**
     * Selects the `none` API value for payment next action type.
     *
     * Wire value: `none`.
     */
    case None = 'none';
}
