<?php

namespace Inttegro\App;

/**
 * Allowed wire values for app relationship kind.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum RelationshipKind: string
{
    /**
     * Selects the `placement` API value for app relationship kind.
     *
     * Wire value: `placement`.
     */
    case Placement = 'placement';
}
