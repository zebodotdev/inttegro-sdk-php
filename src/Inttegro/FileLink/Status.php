<?php

namespace Inttegro\FileLink;

/**
 * Allowed wire values for file link status.
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
     * Previously granted access has been revoked.
     *
     * Wire value: `revoked`.
     */
    case Revoked = 'revoked';

    /**
     * The value is no longer usable because its validity period ended.
     *
     * Wire value: `expired`.
     */
    case Expired = 'expired';

    /**
     * Selects the `disabled` API value for file link status.
     *
     * Wire value: `disabled`.
     */
    case Disabled = 'disabled';
}
