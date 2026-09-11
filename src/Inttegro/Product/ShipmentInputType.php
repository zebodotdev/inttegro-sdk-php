<?php

namespace Inttegro\Product;

/**
 * Allowed wire values for product shipment input type.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum ShipmentInputType: string
{
    /**
     * Selects the `delivery` API value for product shipment input type.
     *
     * Wire value: `delivery`.
     */
    case Delivery = 'delivery';

    /**
     * Selects the `download` API value for product shipment input type.
     *
     * Wire value: `download`.
     */
    case Download = 'download';

    /**
     * Selects the `render` API value for product shipment input type.
     *
     * Wire value: `render`.
     */
    case Render = 'render';

    /**
     * Selects the `stream` API value for product shipment input type.
     *
     * Wire value: `stream`.
     */
    case Stream = 'stream';
}
