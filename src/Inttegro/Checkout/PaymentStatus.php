<?php

namespace Inttegro\Checkout;

/**
 * Payment status.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum PaymentStatus: string
{
    /**
     * Additional customer or merchant action is required before processing can continue.
     *
     * Wire value: `requires_action`.
     */
    case RequiresAction = 'requires_action';

    /**
     * Processing is currently in progress.
     *
     * Wire value: `processing`.
     */
    case Processing = 'processing';

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

    /**
     * The operation was canceled before successful completion.
     *
     * Wire value: `cancelled`.
     */
    case Cancelled = 'cancelled';
}
