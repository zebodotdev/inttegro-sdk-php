<?php

namespace Inttegro\FileReference;


/**
 * Reconciliation details associated with file reference.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Reconciliation extends \Inttegro\DomainValue
{
    /**
     * Reconciled value for this reconciliation.
     *
     * Required response field. PHP type: `bool`; wire field: `reconciled` (`boolean`).
     *
     * @var bool
     */
    public readonly bool $reconciled;

    /**
     * Hydrates a Reconciliation from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->reconciled = \Inttegro\ValueHydrator::bool($data['reconciled'] ?? null, false);
    }

    /**
     * Creates a Reconciliation from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Reconciliation value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
