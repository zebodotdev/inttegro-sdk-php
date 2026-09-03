<?php

namespace Inttegro\Money;

use Inttegro\DomainValue;

/**
 * An amount returned by Inttegro, expressed in integer minor units.
 *
 * @phpstan-consistent-constructor
 */
class Amount extends DomainValue
{
    public function __construct(
        public readonly Currency $currency,
        public readonly int $value,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        $currency = $data['currency'] ?? Currency::GHS;

        return new static(
            $currency instanceof Currency ? $currency : Currency::from(strtolower((string) $currency)),
            (int) ($data['value'] ?? 0),
        );
    }
}
