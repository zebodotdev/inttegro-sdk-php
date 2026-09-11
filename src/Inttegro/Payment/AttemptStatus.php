<?php

namespace Inttegro\Payment;

/**
 * Allowed wire values for payment attempt status.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum AttemptStatus: string
{
    /**
     * Processing has been initiated.
     *
     * Wire value: `initiated`.
     */
    case Initiated = 'initiated';

    /**
     * Execution has been started or completed as defined by the resource lifecycle.
     *
     * Wire value: `executed`.
     */
    case Executed = 'executed';

    /**
     * The operation completed successfully.
     *
     * Wire value: `succeeded`.
     */
    case Succeeded = 'succeeded';

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
