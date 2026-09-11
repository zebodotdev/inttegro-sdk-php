<?php

namespace Inttegro\PaymentMethod;


/**
 * Settings for a specific payment method type.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class TypeSetting extends \Inttegro\DomainValue
{
    /**
     * Payment method type.
     *
     * Optional response field. PHP type: `string|null`; wire field: `type` (`string`).
     * Compare against `Type` cases by using their `->value` strings.
     *
     * @var string|null
     */
    public readonly ?string $type;

    /**
     * Human-readable name.
     *
     * Optional response field. PHP type: `string|null`; wire field: `name` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $name;

    /**
     * Description of this payment method.
     *
     * Optional response field. PHP type: `string|null`; wire field: `description` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $description;

    /**
     * Whether this payment type can be used.
     *
     * Required response field. PHP type: `bool`; wire field: `enabled` (`boolean`).
     *
     * @var bool
     */
    public readonly bool $enabled;

    /**
     * Whether customers must explicitly agree before using.
     *
     * Required response field. PHP type: `bool`; wire field: `confirms_use` (`boolean`).
     *
     * @var bool
     */
    public readonly bool $confirmsUse;

    /**
     * Hydrates a TypeSetting from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, true);
        $this->name = \Inttegro\ValueHydrator::string($data['name'] ?? null, true);
        $this->description = \Inttegro\ValueHydrator::string($data['description'] ?? null, true);
        $this->enabled = \Inttegro\ValueHydrator::bool($data['enabled'] ?? null, false);
        $this->confirmsUse = \Inttegro\ValueHydrator::bool($data['confirms_use'] ?? null, false);
    }

    /**
     * Creates a TypeSetting from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable TypeSetting value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
