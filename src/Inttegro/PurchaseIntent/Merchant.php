<?php

namespace Inttegro\PurchaseIntent;


/**
 * Merchant identity captured for the hosted checkout. Individual fields are omitted when
 * unavailable.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Merchant extends \Inttegro\DomainValue
{
    /**
     * App Name value for this merchant.
     *
     * Optional response field. PHP type: `string|null`; wire field: `app_name` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $appName;

    /**
     * Identifier of the related organization.
     *
     * Optional response field. PHP type: `string|null`; wire field: `organization_id` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $organizationId;

    /**
     * Organization Name value for this merchant.
     *
     * Optional response field. PHP type: `string|null`; wire field: `organization_name` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $organizationName;

    /**
     * Hydrates a Merchant from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->appName = \Inttegro\ValueHydrator::string($data['app_name'] ?? null, true);
        $this->organizationId = \Inttegro\ValueHydrator::string($data['organization_id'] ?? null, true);
        $this->organizationName = \Inttegro\ValueHydrator::string($data['organization_name'] ?? null, true);
    }

    /**
     * Creates a Merchant from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Merchant value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
