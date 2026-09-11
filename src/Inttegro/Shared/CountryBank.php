<?php

namespace Inttegro\Shared;


/**
 * A banking institution available in a country.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class CountryBank extends \Inttegro\DomainValue
{
    /**
     * Stable bank identifier.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Bank display name.
     *
     * Required response field. PHP type: `string`; wire field: `name` (`string`).
     *
     * @var string
     */
    public readonly string $name;

    /**
     * SWIFT/BIC code for the bank, when available.
     *
     * Optional response field. PHP type: `string|null`; wire field: `swift_code` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $swiftCode;

    /**
     * Ghana sort code prefix for the bank.
     *
     * Optional response field. PHP type: `string|null`; wire field: `sort_code_prefix` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $sortCodePrefix;

    /**
     * Branches available for this bank.
     *
     * Required response field. PHP type: `list<\Inttegro\Shared\CountryBankBranch>`; wire field:
     * `branches` (`array<object>`).
     * When the field is absent, the SDK exposes an empty collection.
     *
     * @var list<\Inttegro\Shared\CountryBankBranch>
     */
    public readonly array $branches;

    /**
     * Hydrates a CountryBank from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->name = \Inttegro\ValueHydrator::string($data['name'] ?? null, false);
        $this->swiftCode = \Inttegro\ValueHydrator::string($data['swift_code'] ?? null, true);
        $this->sortCodePrefix = \Inttegro\ValueHydrator::string($data['sort_code_prefix'] ?? null, true);
        $this->branches = \Inttegro\ValueHydrator::objects($data['branches'] ?? null, [\Inttegro\Shared\CountryBankBranch::class]);
    }

    /**
     * Creates a CountryBank from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable CountryBank value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
