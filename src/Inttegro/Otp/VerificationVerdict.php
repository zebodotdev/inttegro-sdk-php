<?php

namespace Inttegro\Otp;

/**
 * Allowed wire values for otp verification verdict.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum VerificationVerdict: string
{
    /**
     * Selects the `fail` API value for otp verification verdict.
     *
     * Wire value: `fail`.
     */
    case Fail = 'fail';

    /**
     * Selects the `pass` API value for otp verification verdict.
     *
     * Wire value: `pass`.
     */
    case Pass = 'pass';
}
