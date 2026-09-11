<?php

namespace Inttegro\App;

/**
 * Allowed wire values for app relationship status.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum RelationshipStatus: string
{
    /**
     * The value is active and available for normal use.
     *
     * Wire value: `active`.
     */
    case Active = 'active';

    /**
     * The value is inactive and cannot be used normally.
     *
     * Wire value: `inactive`.
     */
    case Inactive = 'inactive';

    /**
     * Selects the `suspended` API value for app relationship status.
     *
     * Wire value: `suspended`.
     */
    case Suspended = 'suspended';

    /**
     * Previously granted access has been revoked.
     *
     * Wire value: `revoked`.
     */
    case Revoked = 'revoked';
}
