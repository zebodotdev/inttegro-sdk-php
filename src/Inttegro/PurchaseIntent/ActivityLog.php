<?php

namespace Inttegro\PurchaseIntent;


/**
 * Recent authenticated-owner activity for the purchase intent.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class ActivityLog extends \Inttegro\DomainValue
{
    /**
     * Recent value for this activity log.
     *
     * Optional response field. PHP type: `list<\Inttegro\PurchaseIntent\Activity>|null`; wire
     * field: `recent` (`array<object>`).
     * When the field is absent, the SDK exposes an empty collection.
     *
     * @var list<\Inttegro\PurchaseIntent\Activity>|null
     */
    public readonly ?array $recent;

    /**
     * Hydrates an ActivityLog from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->recent = \Inttegro\ValueHydrator::objects($data['recent'] ?? null, [\Inttegro\PurchaseIntent\Activity::class]);
    }

    /**
     * Creates an ActivityLog from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable ActivityLog value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
