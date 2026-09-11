<?php

namespace Inttegro\Product;


/**
 * Delivery details associated with product.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Delivery extends \Inttegro\DomainValue
{
    /**
     * Hydrates a Delivery from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data) { unset($data); }

    /**
     * Creates a Delivery from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Delivery value.
     */
    public static function fromArray(array $data): static { return new static($data); }
}
