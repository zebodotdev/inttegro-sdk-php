<?php

namespace Inttegro\Price;

use Inttegro\Money\AmountParams;

/**
 * Typed parameters for creating a reusable catalog price.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Params extends \Inttegro\DomainValue
{
    /**
     * Creates typed parameters for a catalog price.
     *
     * Nullable properties are omitted by `toArray()` so the API can apply its defaults.
     *
     * @param AmountParams $amount Required price amount. Wire field: `amount` (`object`).
     * @param string|null $productId Optional product ID. Wire field: `product_id` (`string`).
     * @param string|null $label Optional customer-facing label. Wire field: `label` (`string`).
     * @param string|null $about Optional explanatory text. Wire field: `about` (`string`).
     */
    public function __construct(
        /** Required. PHP type: `AmountParams`; wire field: `amount` (`object`). */
        public readonly AmountParams $amount,
        /** Optional. PHP type: `string|null`; wire field: `product_id` (`string`). */
        public readonly ?string $productId = null,
        /** Optional. PHP type: `string|null`; wire field: `label` (`string`). */
        public readonly ?string $label = null,
        /** Optional. PHP type: `string|null`; wire field: `about` (`string`). */
        public readonly ?string $about = null,
    ) {}

    /**
     * Creates a Params from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Params value.
     */
    public static function fromArray(array $data): static
    {
        $amount = $data['amount'] ?? [];

        return new static(
            $amount instanceof AmountParams ? $amount : AmountParams::fromArray(is_array($amount) ? $amount : []),
            isset($data['product_id']) ? (string) $data['product_id'] : null,
            isset($data['label']) ? (string) $data['label'] : null,
            isset($data['about']) ? (string) $data['about'] : null,
        );
    }

    /**
     * Returns the API wire object and omits every optional field whose value is null.
     *
     * @return array<string, mixed> A `snake_case` request payload.
     */
    public function toArray(): array
    {
        return array_filter(parent::toArray(), static fn(mixed $value): bool => $value !== null);
    }
}
