<?php

namespace Inttegro\Product;

/**
 * Allowed wire values for product shipment type.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum ShipmentType: string
{
    /**
     * Selects the `delivery` API value for product shipment type.
     *
     * Wire value: `delivery`.
     */
    case Delivery = 'delivery';

    /**
     * Selects the `download` API value for product shipment type.
     *
     * Wire value: `download`.
     */
    case Download = 'download';

    /**
     * Selects the `render` API value for product shipment type.
     *
     * Wire value: `render`.
     */
    case Render = 'render';

    /**
     * Identifies a service product.
     *
     * Wire value: `service`.
     */
    case Service = 'service';

    /**
     * Selects the `stream` API value for product shipment type.
     *
     * Wire value: `stream`.
     */
    case Stream = 'stream';
}
