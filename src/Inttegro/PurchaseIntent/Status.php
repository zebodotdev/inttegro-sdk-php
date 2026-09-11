<?php

namespace Inttegro\PurchaseIntent;

/**
 * Effective lifecycle state derived from expiry, cancellation, and single-use order creation.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum Status: string
{
    /**
     * The value is active and available for normal use.
     *
     * Wire value: `active`.
     */
    case Active = 'active';

    /**
     * The value is no longer usable because its validity period ended.
     *
     * Wire value: `expired`.
     */
    case Expired = 'expired';

    /**
     * The value is inactive and cannot be used normally.
     *
     * Wire value: `inactive`.
     */
    case Inactive = 'inactive';

    /**
     * Selects the `used` API value for purchase intent status.
     *
     * Wire value: `used`.
     */
    case Used = 'used';
}
