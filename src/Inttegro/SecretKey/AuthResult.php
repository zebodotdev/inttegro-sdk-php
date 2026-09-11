<?php

namespace Inttegro\SecretKey;

/**
 * Allowed wire values for secret key auth result.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum AuthResult: string
{
    /**
     * The operation completed successfully.
     *
     * Wire value: `succeeded`.
     */
    case Succeeded = 'succeeded';

    /**
     * The operation did not complete successfully.
     *
     * Wire value: `failed`.
     */
    case Failed = 'failed';
}
