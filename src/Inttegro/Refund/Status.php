<?php

namespace Inttegro\Refund;

/**
 * Allowed wire values for refund status.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum Status: string
{
    /**
     * The operation was canceled before successful completion.
     *
     * Wire value: `canceled`.
     */
    case Canceled = 'canceled';

    /**
     * The operation did not complete successfully.
     *
     * Wire value: `failed`.
     */
    case Failed = 'failed';

    /**
     * Processing has not completed yet.
     *
     * Wire value: `pending`.
     */
    case Pending = 'pending';

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
}
