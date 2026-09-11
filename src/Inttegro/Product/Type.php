<?php

namespace Inttegro\Product;

/**
 * Product type - determines fulfillment requirements.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum Type: string
{
    /**
     * Identifies a physical product that requires real-world fulfillment.
     *
     * Wire value: `physical`.
     */
    case Physical = 'physical';

    /**
     * Identifies a digitally delivered product.
     *
     * Wire value: `digital`.
     */
    case Digital = 'digital';

    /**
     * Identifies a service product.
     *
     * Wire value: `service`.
     */
    case Service = 'service';

    /**
     * Identifies a voucher product.
     *
     * Wire value: `voucher`.
     */
    case Voucher = 'voucher';

    /**
     * Identifies an application-defined variant.
     *
     * Wire value: `custom`.
     */
    case Custom = 'custom';

    /**
     * Identifies a cause or donation product.
     *
     * Wire value: `cause`.
     */
    case Cause = 'cause';
}
