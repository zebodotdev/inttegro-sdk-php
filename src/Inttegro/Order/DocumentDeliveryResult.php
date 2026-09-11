<?php

namespace Inttegro\Order;


/**
 * Response returned by deliberate order document delivery endpoints.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class DocumentDeliveryResult extends \Inttegro\DomainValue
{
    /**
     * Delivery result for one hosted order document link.
     *
     * Optional response field. PHP type: `\Inttegro\Order\DocumentDelivery|null`; wire field:
     * `delivery` (`object`).
     *
     * @var \Inttegro\Order\DocumentDelivery|null
     */
    public readonly ?\Inttegro\Order\DocumentDelivery $delivery;

    /**
     * Standard error response structure returned by all API endpoints. Provides machine-readable
     * codes, human-readable messages, and actionable guidance for resolution.
     *
     * Optional response field. PHP type: `\Inttegro\Shared\Error|null`; wire field: `error`
     * (`object`).
     *
     * @var \Inttegro\Shared\Error|null
     */
    public readonly ?\Inttegro\Shared\Error $error;

    /**
     * Complete order record with line items, customer details, payment state, and fulfillment
     * information.
     *
     * Optional response field. PHP type: `\Inttegro\Order\Order|null`; wire field: `order`
     * (`object`).
     *
     * @var \Inttegro\Order\Order|null
     */
    public readonly ?\Inttegro\Order\Order $order;

    /**
     * Hydrates a DocumentDeliveryResult from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->delivery = \Inttegro\ValueHydrator::object($data['delivery'] ?? null, [\Inttegro\Order\DocumentDelivery::class], true);
        $this->error = \Inttegro\ValueHydrator::object($data['error'] ?? null, [\Inttegro\Shared\Error::class], true);
        $this->order = \Inttegro\ValueHydrator::object($data['order'] ?? null, [\Inttegro\Order\Order::class], true);
    }

    /**
     * Creates a DocumentDeliveryResult from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable DocumentDeliveryResult value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
