<?php

namespace Inttegro\Shared;


/**
 * Country Specifications details associated with shared.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class CountrySpecifications extends \Inttegro\DomainValue
{
    /**
     * Country specifications keyed by country code.
     *
     * Required response field. PHP type: `array<string, \Inttegro\Shared\CountrySpecification>`;
     * wire field: `countries` (`object`).
     * When the field is absent, the SDK exposes an empty collection.
     *
     * @var array<string, \Inttegro\Shared\CountrySpecification>
     */
    public readonly array $countries;

    /**
     * Hydrates a CountrySpecifications from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->countries = \Inttegro\ValueHydrator::objectMap($data['countries'] ?? $data, [\Inttegro\Shared\CountrySpecification::class]);
    }

    /**
     * Creates a CountrySpecifications from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable CountrySpecifications value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
