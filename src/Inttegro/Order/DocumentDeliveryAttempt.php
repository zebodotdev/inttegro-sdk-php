<?php

namespace Inttegro\Order;


/**
 * Chime delivery accepted for one channel.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class DocumentDeliveryAttempt extends \Inttegro\DomainValue
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
     * Chime ID created for this delivery.
     *
     * Optional response field. PHP type: `string|null`; wire field: `chime_id` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $chimeId;

    /**
     * Hydrates a DocumentDeliveryAttempt from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->channel = \Inttegro\ValueHydrator::string($data['channel'] ?? null, true);
        $this->chimeId = \Inttegro\ValueHydrator::string($data['chime_id'] ?? null, true);
    }

    /**
     * Creates a DocumentDeliveryAttempt from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable DocumentDeliveryAttempt value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
