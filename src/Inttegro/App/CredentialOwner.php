<?php

namespace Inttegro\App;

/**
 * Who can create, rotate, or disable the child app's API keys after creation. Defaults to child. In V1, apps/create still returns the initial child key to the caller.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum CredentialOwner: string
{
    /**
     * Selects the `child` API value for app credential owner.
     *
     * Wire value: `child`.
     */
    case Child = 'child';

    /**
     * Selects the `parent` API value for app credential owner.
     *
     * Wire value: `parent`.
     */
    case ParentApp = 'parent';
}
