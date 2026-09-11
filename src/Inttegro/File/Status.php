<?php

namespace Inttegro\File;

/**
 * Allowed wire values for file status.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum Status: string
{
    /**
     * Selects the `uploading` API value for file status.
     *
     * Wire value: `uploading`.
     */
    case Uploading = 'uploading';

    /**
     * Processing is currently in progress.
     *
     * Wire value: `processing`.
     */
    case Processing = 'processing';

    /**
     * The value is available for use.
     *
     * Wire value: `available`.
     */
    case Available = 'available';

    /**
     * The operation did not complete successfully.
     *
     * Wire value: `failed`.
     */
    case Failed = 'failed';

    /**
     * The value has been deleted.
     *
     * Wire value: `deleted`.
     */
    case Deleted = 'deleted';
}
