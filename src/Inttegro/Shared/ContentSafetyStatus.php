<?php

namespace Inttegro\Shared;

/**
 * Allowed wire values for shared content safety status.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum ContentSafetyStatus: string
{
    /**
     * Selects the `allowed` API value for shared content safety status.
     *
     * Wire value: `allowed`.
     */
    case Allowed = 'allowed';

    /**
     * Selects the `rejected` API value for shared content safety status.
     *
     * Wire value: `rejected`.
     */
    case Rejected = 'rejected';

    /**
     * Selects the `quarantined` API value for shared content safety status.
     *
     * Wire value: `quarantined`.
     */
    case Quarantined = 'quarantined';
}
