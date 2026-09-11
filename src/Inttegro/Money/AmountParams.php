<?php

namespace Inttegro\Money;

use Inttegro\DomainValue;

/**
 * A monetary amount supplied in a request, pairing an ISO 4217 currency with integer minor units.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 * @phpstan-consistent-constructor
 */
class AmountParams extends DomainValue
{
    /**
     * Creates a typed amount for an API request.
     *
     * @param Currency $currency Required ISO 4217 currency. Wire field: `currency` (`string`).
     * @param int $value Required integer minor-unit value. Wire field: `value` (`integer`).
     */
    public function __construct(
        /** Required. PHP type: `Currency`; wire field: `currency` (`string`). */
        public readonly Currency $currency,
        /** Required. PHP type: `int`; wire field: `value` (`integer` minor units). */
        public readonly int $value,
    ) {}

    /**
     * Creates an AmountParams from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable AmountParams value.
     */
    public static function fromArray(array $data): static
    {
        $currency = $data['currency'] ?? Currency::GHS;

        return new static(
            $currency instanceof Currency ? $currency : Currency::from(strtolower((string) $currency)),
            (int) ($data['value'] ?? 0),
        );
    }
}
