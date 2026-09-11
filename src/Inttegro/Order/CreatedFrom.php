<?php

namespace Inttegro\Order;


/**
 * Created From details associated with order.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class CreatedFrom extends \Inttegro\DomainValue
{
    /**
     * Source value for this created from.
     *
     * Optional response field. PHP type: `string|null`; wire field: `source` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $source;

    /**
     * Resource Type value for this created from.
     *
     * Optional response field. PHP type: `string|null`; wire field: `resource_type` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $resourceType;

    /**
     * Identifier of the related resource.
     *
     * Optional response field. PHP type: `string|null`; wire field: `resource_id` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $resourceId;

    /**
     * Hydrates a CreatedFrom from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->source = \Inttegro\ValueHydrator::string($data['source'] ?? null, true);
        $this->resourceType = \Inttegro\ValueHydrator::string($data['resource_type'] ?? null, true);
        $this->resourceId = \Inttegro\ValueHydrator::string($data['resource_id'] ?? null, true);
    }

    /**
     * Creates a CreatedFrom from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable CreatedFrom value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
