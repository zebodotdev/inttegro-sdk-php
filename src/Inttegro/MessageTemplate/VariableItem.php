<?php

namespace Inttegro\MessageTemplate;


/**
 * Variable Item details associated with message template.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class VariableItem extends \Inttegro\DomainValue
{
    /**
     * Additional explanatory text.
     *
     * Optional response field. PHP type: `string|null`; wire field: `about` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $about;

    /**
     * Default value for this variable item.
     *
     * Required response field. PHP type: `mixed`; wire field: `default` (`object`).
     *
     * @var mixed
     */
    public readonly mixed $default;

    /**
     * Human-readable name.
     *
     * Required response field. PHP type: `string`; wire field: `name` (`string`).
     *
     * @var string
     */
    public readonly string $name;

    /**
     * Required value for this variable item.
     *
     * Required response field. PHP type: `bool`; wire field: `required` (`boolean`).
     *
     * @var bool
     */
    public readonly bool $required;

    /**
     * Discriminator identifying the value's API variant.
     *
     * Required response field. PHP type: `string`; wire field: `type` (`string`).
     *
     * @var string
     */
    public readonly string $type;

    /**
     * Hydrates a VariableItem from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->about = \Inttegro\ValueHydrator::string($data['about'] ?? null, true);
        $this->default = $data['default'] ?? null;
        $this->name = \Inttegro\ValueHydrator::string($data['name'] ?? null, false);
        $this->required = \Inttegro\ValueHydrator::bool($data['required'] ?? null, false);
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
    }

    /**
     * Creates a VariableItem from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable VariableItem value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
