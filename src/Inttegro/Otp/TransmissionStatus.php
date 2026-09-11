<?php

namespace Inttegro\Otp;

/**
 * Allowed wire values for otp transmission status.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum TransmissionStatus: string
{
    /**
     * Selects the `delivered` API value for otp transmission status.
     *
     * Wire value: `delivered`.
     */
    case Delivered = 'delivered';

    /**
     * The operation did not complete successfully.
     *
     * Wire value: `failed`.
     */
    case Failed = 'failed';

    /**
     * Selects the `submitted` API value for otp transmission status.
     *
     * Wire value: `submitted`.
     */
    case Submitted = 'submitted';
}
