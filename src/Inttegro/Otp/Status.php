<?php

namespace Inttegro\Otp;

/**
 * Allowed wire values for otp status.
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
     * The value is no longer usable because its validity period ended.
     *
     * Wire value: `expired`.
     */
    case Expired = 'expired';

    /**
     * Processing has not completed yet.
     *
     * Wire value: `pending`.
     */
    case Pending = 'pending';

    /**
     * Selects the `pending_delivery` API value for otp status.
     *
     * Wire value: `pending_delivery`.
     */
    case PendingDelivery = 'pending_delivery';

    /**
     * Selects the `pending_verification` API value for otp status.
     *
     * Wire value: `pending_verification`.
     */
    case PendingVerification = 'pending_verification';

    /**
     * Verification completed successfully.
     *
     * Wire value: `verified`.
     */
    case Verified = 'verified';
}
