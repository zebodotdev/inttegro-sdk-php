<?php

namespace Inttegro\File;

/**
 * Allowed wire values for file scan status.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum ScanStatus: string
{
    /**
     * Processing has not completed yet.
     *
     * Wire value: `pending`.
     */
    case Pending = 'pending';

    /**
     * The check completed without finding a blocking issue.
     *
     * Wire value: `passed`.
     */
    case Passed = 'passed';

    /**
     * The operation did not complete successfully.
     *
     * Wire value: `failed`.
     */
    case Failed = 'failed';

    /**
     * The check was intentionally not performed.
     *
     * Wire value: `skipped`.
     */
    case Skipped = 'skipped';
}
