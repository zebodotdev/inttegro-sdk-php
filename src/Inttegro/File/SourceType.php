<?php

namespace Inttegro\File;

/**
 * Allowed wire values for file source type.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum SourceType: string
{
    /**
     * Selects the `direct` API value for file source type.
     *
     * Wire value: `direct`.
     */
    case Direct = 'direct';

    /**
     * Selects the `upload_request` API value for file source type.
     *
     * Wire value: `upload_request`.
     */
    case UploadRequest = 'upload_request';

    /**
     * Identifies a service product.
     *
     * Wire value: `service`.
     */
    case Service = 'service';
}
