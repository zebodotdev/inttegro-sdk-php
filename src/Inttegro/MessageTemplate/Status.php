<?php

namespace Inttegro\MessageTemplate;

/**
 * Allowed wire values for message template status.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum Status: string
{
    /**
     * Selects the `draft` API value for message template status.
     *
     * Wire value: `draft`.
     */
    case Draft = 'draft';

    /**
     * Selects the `published` API value for message template status.
     *
     * Wire value: `published`.
     */
    case Published = 'published';

    /**
     * The value has been archived and is retained for historical access.
     *
     * Wire value: `archived`.
     */
    case Archived = 'archived';
}
