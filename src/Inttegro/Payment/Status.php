<?php

namespace Inttegro\Payment;

/**
 * Payment state.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum Status: string
{
    /**
     * Processing has been initiated.
     *
     * Wire value: `initiated`.
     */
    case Initiated = 'initiated';

    /**
     * Additional customer or merchant action is required before processing can continue.
     *
     * Wire value: `requires_action`.
     */
    case RequiresAction = 'requires_action';

    /**
     * The operation passed its due time without completing.
     *
     * Wire value: `overdue`.
     */
    case Overdue = 'overdue';

    /**
     * Execution has been started or completed as defined by the resource lifecycle.
     *
     * Wire value: `executed`.
     */
    case Executed = 'executed';

    /**
     * Payment completed successfully.
     *
     * Wire value: `paid`.
     */
    case Paid = 'paid';

    /**
     * The operation was canceled before successful completion.
     *
     * Wire value: `canceled`.
     */
    case Canceled = 'canceled';

    /**
     * The value is no longer usable because its validity period ended.
     *
     * Wire value: `expired`.
     */
    case Expired = 'expired';

    /**
     * The operation did not complete successfully.
     *
     * Wire value: `failed`.
     */
    case Failed = 'failed';

    /**
     * The API could not classify the value more specifically.
     *
     * Wire value: `unknown`.
     */
    case Unknown = 'unknown';
}
