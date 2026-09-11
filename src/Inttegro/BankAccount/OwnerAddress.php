<?php

namespace Inttegro\BankAccount;


/**
 * Postal address details associated with bank account.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class OwnerAddress extends \Inttegro\DomainValue
{
    /**
     * City value for this owner address.
     *
     * Required response field. PHP type: `string`; wire field: `city` (`string`).
     *
     * @var string
     */
    public readonly string $city;

    /**
     * Country value for this owner address.
     *
     * Required response field. PHP type: `string`; wire field: `country` (`string`).
     *
     * @var string
     */
    public readonly string $country;

    /**
     * Line1 value for this owner address.
     *
     * Required response field. PHP type: `string`; wire field: `line_1` (`string`).
     *
     * @var string
     */
    public readonly string $line1;

    /**
     * Line2 value for this owner address.
     *
     * Optional response field. PHP type: `string|null`; wire field: `line_2` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $line2;

    /**
     * Human-readable name.
     *
     * Optional response field. PHP type: `string|null`; wire field: `name` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $name;

    /**
     * Phone value for this owner address.
     *
     * Optional response field. PHP type: `string|null`; wire field: `phone` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $phone;

    /**
     * Post Code value for this owner address.
     *
     * Optional response field. PHP type: `string|null`; wire field: `post_code` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $postCode;

    /**
     * Region value for this owner address.
     *
     * Required response field. PHP type: `string`; wire field: `region` (`string`).
     *
     * @var string
     */
    public readonly string $region;

    /**
     * Hydrates an OwnerAddress from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->city = \Inttegro\ValueHydrator::string($data['city'] ?? null, false);
        $this->country = \Inttegro\ValueHydrator::string($data['country'] ?? null, false);
        $this->line1 = \Inttegro\ValueHydrator::string($data['line_1'] ?? null, false);
        $this->line2 = \Inttegro\ValueHydrator::string($data['line_2'] ?? null, true);
        $this->name = \Inttegro\ValueHydrator::string($data['name'] ?? null, true);
        $this->phone = \Inttegro\ValueHydrator::string($data['phone'] ?? null, true);
        $this->postCode = \Inttegro\ValueHydrator::string($data['post_code'] ?? null, true);
        $this->region = \Inttegro\ValueHydrator::string($data['region'] ?? null, false);
    }

    /**
     * Creates an OwnerAddress from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable OwnerAddress value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
