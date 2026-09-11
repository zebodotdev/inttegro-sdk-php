<?php

namespace Inttegro\UploadRequest;

/**
 * Allowed wire values for upload request review type.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum ReviewType: string
{
    /**
     * Selects the `automatic` API value for upload request review type.
     *
     * Wire value: `automatic`.
     */
    case Automatic = 'automatic';

    /**
     * Selects the `manual` API value for upload request review type.
     *
     * Wire value: `manual`.
     */
    case Manual = 'manual';
}
