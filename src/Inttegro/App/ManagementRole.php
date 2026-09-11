<?php

namespace Inttegro\App;

/**
 * Who can manage the child app and its resources through this relationship.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum ManagementRole: string
{
    /**
     * Selects the `parent` API value for app management role.
     *
     * Wire value: `parent`.
     */
    case ParentApp = 'parent';

    /**
     * Selects the `child` API value for app management role.
     *
     * Wire value: `child`.
     */
    case Child = 'child';
}
