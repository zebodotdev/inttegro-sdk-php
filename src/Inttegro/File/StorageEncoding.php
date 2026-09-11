<?php

namespace Inttegro\File;

/**
 * Encoding of the stored representation.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum StorageEncoding: string
{
    /**
     * Selects the `identity` API value for file storage encoding.
     *
     * Wire value: `identity`.
     */
    case Identity = 'identity';

    /**
     * Selects the `br` API value for file storage encoding.
     *
     * Wire value: `br`.
     */
    case Brotli = 'br';
}
