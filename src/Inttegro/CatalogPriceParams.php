<?php

namespace Inttegro;

use Inttegro\Money\AmountParams;

/** Parameters for creating a reusable catalog price. */
final class CatalogPriceParams extends DomainValue
{
    public function __construct(
        public readonly AmountParams $amount,
        public readonly ?string $productId = null,
        public readonly ?string $label = null,
        public readonly ?string $about = null,
    ) {}

    /** @param array<string, mixed> $data */
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

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return array_filter(parent::toArray(), static fn(mixed $value): bool => $value !== null);
    }
}
