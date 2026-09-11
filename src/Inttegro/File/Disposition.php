<?php

namespace Inttegro\File;

/**
 * Allowed wire values for file disposition.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum Disposition: string
{
    /**
     * Selects the `attachment` API value for file disposition.
     *
     * Wire value: `attachment`.
     */
    case Attachment = 'attachment';

    /**
     * Selects the `inline` API value for file disposition.
     *
     * Wire value: `inline`.
     */
    case Inline = 'inline';
}
