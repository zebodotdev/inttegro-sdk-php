<?php

namespace Inttegro\Payment;

/**
 * Payment status.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum ResultStatus: string
{
    /**
     * Processing has not completed yet.
     *
     * Wire value: `pending`.
     */
    case Pending = 'pending';

    /**
     * Selects the `requires_confirmation` API value for payment result status.
     *
     * Wire value: `requires_confirmation`.
     */
    case RequiresConfirmation = 'requires_confirmation';

    /**
     * Processing is currently in progress.
     *
     * Wire value: `processing`.
     */
    case Processing = 'processing';

    /**
     * The operation completed successfully.
     *
     * Wire value: `succeeded`.
     */
    case Succeeded = 'succeeded';

    /**
     * The operation did not complete successfully.
     *
     * Wire value: `failed`.
     */
    case Failed = 'failed';
}
