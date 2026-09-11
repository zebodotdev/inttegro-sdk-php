<?php

namespace Inttegro\Product;


/**
 * Shipment details associated with product.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Shipment extends \Inttegro\DomainValue
{
    /**
     * Discriminator identifying the value's API variant.
     *
     * Required response field. PHP type: `string`; wire field: `type` (`string`).
     * Compare against `Type` cases by using their `->value` strings.
     *
     * @var string
     */
    public readonly string $type;

    /**
     * Delivery fulfillment marker.
     *
     * Optional response field. PHP type: `\Inttegro\Product\Delivery|null`; wire field: `delivery`
     * (`object`).
     *
     * @var \Inttegro\Product\Delivery|null
     */
    public readonly ?\Inttegro\Product\Delivery $delivery;

    /**
     * Download fulfillment marker.
     *
     * Optional response field. PHP type: `\Inttegro\Product\Download|null`; wire field: `download`
     * (`object`).
     *
     * @var \Inttegro\Product\Download|null
     */
    public readonly ?\Inttegro\Product\Download $download;

    /**
     * Rendered fulfillment marker.
     *
     * Optional response field. PHP type: `\Inttegro\Product\Render|null`; wire field: `render`
     * (`object`).
     *
     * @var \Inttegro\Product\Render|null
     */
    public readonly ?\Inttegro\Product\Render $render;

    /**
     * Service fulfillment marker.
     *
     * Optional response field. PHP type: `\Inttegro\Product\Service|null`; wire field: `service`
     * (`object`).
     *
     * @var \Inttegro\Product\Service|null
     */
    public readonly ?\Inttegro\Product\Service $service;

    /**
     * Streaming fulfillment marker.
     *
     * Optional response field. PHP type: `\Inttegro\Product\Stream|null`; wire field: `stream`
     * (`object`).
     *
     * @var \Inttegro\Product\Stream|null
     */
    public readonly ?\Inttegro\Product\Stream $stream;

    /**
     * Hydrates a Shipment from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
        $this->delivery = \Inttegro\ValueHydrator::object($data['delivery'] ?? null, [\Inttegro\Product\Delivery::class], true);
        $this->download = \Inttegro\ValueHydrator::object($data['download'] ?? null, [\Inttegro\Product\Download::class], true);
        $this->render = \Inttegro\ValueHydrator::object($data['render'] ?? null, [\Inttegro\Product\Render::class], true);
        $this->service = \Inttegro\ValueHydrator::object($data['service'] ?? null, [\Inttegro\Product\Service::class], true);
        $this->stream = \Inttegro\ValueHydrator::object($data['stream'] ?? null, [\Inttegro\Product\Stream::class], true);
    }

    /**
     * Creates a Shipment from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Shipment value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
