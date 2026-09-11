<?php

namespace Inttegro\Order;


/**
 * Chime delivery failure for one channel.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class DocumentDeliveryFailure extends \Inttegro\DomainValue
{
    /**
     * Delivery channel.
     *
     * Optional response field. PHP type: `string|null`; wire field: `channel` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $channel;

    /**
     * Provider or Chime error for this channel.
     *
     * Optional response field. PHP type: `string|null`; wire field: `error` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $error;

    /**
     * Hydrates a DocumentDeliveryFailure from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->channel = \Inttegro\ValueHydrator::string($data['channel'] ?? null, true);
        $this->error = \Inttegro\ValueHydrator::string($data['error'] ?? null, true);
    }

    /**
     * Creates a DocumentDeliveryFailure from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable DocumentDeliveryFailure value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
