<?php

namespace Inttegro\UploadRequest;

/**
 * Allowed wire values for upload request review decision.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum ReviewDecision: string
{
    /**
     * Selects the `approved` API value for upload request review decision.
     *
     * Wire value: `approved`.
     */
    case Approved = 'approved';

    /**
     * Selects the `rejected` API value for upload request review decision.
     *
     * Wire value: `rejected`.
     */
    case Rejected = 'rejected';
}
