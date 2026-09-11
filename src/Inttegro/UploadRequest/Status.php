<?php

namespace Inttegro\UploadRequest;

/**
 * Allowed wire values for upload request status.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum Status: string
{
    /**
     * Processing has not completed yet.
     *
     * Wire value: `pending`.
     */
    case Pending = 'pending';

    /**
     * Selects the `uploading` API value for upload request status.
     *
     * Wire value: `uploading`.
     */
    case Uploading = 'uploading';

    /**
     * Selects the `fulfilled` API value for upload request status.
     *
     * Wire value: `fulfilled`.
     */
    case Fulfilled = 'fulfilled';

    /**
     * The value is no longer usable because its validity period ended.
     *
     * Wire value: `expired`.
     */
    case Expired = 'expired';

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
}
