<?php

namespace Inttegro\Price;

use DateTimeImmutable;
use Inttegro\Money\Amount;

/**
 * A reusable catalog price that can be attached to products and order line items.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Price extends \Inttegro\DomainValue
{
    /**
     * Unique price identifier with pr_ prefix.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Short label for this price.
     *
     * Optional response field. PHP type: `string|null`; wire field: `label` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $label;

    /**
     * Longer description of this price.
     *
     * Optional response field. PHP type: `string|null`; wire field: `about` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $about;

    /**
     * Whether this price is active and usable in new flows.
     *
     * Required response field. PHP type: `bool`; wire field: `active` (`boolean`).
     *
     * @var bool
     */
    public readonly bool $active;

    /**
     * Price amount.
     *
     * Required response field. PHP type: `Amount`; wire field: `nominal` (`object`).
     *
     * @var Amount
     */
    public readonly Amount $nominal;

    /**
     * Product ID when the operation returns the relationship by reference.
     *
     * Optional response field. PHP type: `string|null`; wire field: `product_id` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $productId;

    /**
     * Embedded product details, if this price belongs to a product.
     *
     * Optional response field. PHP type: `\Inttegro\Price\EmbeddedProduct|null`; wire field:
     * `product` (`object`).
     *
     * @var \Inttegro\Price\EmbeddedProduct|null
     */
    public readonly ?\Inttegro\Price\EmbeddedProduct $product;

    /**
     * Price creation timestamp.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `created_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $createdAt;

    /**
     * Last update timestamp.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `updated_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $updatedAt;

    /**
     * Archive timestamp (if archived).
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `archived_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $archivedAt;

    /**
     * Hydrates a Price from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->label = \Inttegro\ValueHydrator::string($data['label'] ?? null, true);
        $this->about = \Inttegro\ValueHydrator::string($data['about'] ?? null, true);
        $this->active = \Inttegro\ValueHydrator::bool($data['active'] ?? null, false);
        $this->nominal = \Inttegro\ValueHydrator::object($data['nominal'] ?? null, [Amount::class], false);
        $this->productId = \Inttegro\ValueHydrator::string($data['product_id'] ?? null, true);
        $this->product = \Inttegro\ValueHydrator::object($data['product'] ?? null, [\Inttegro\Price\EmbeddedProduct::class], true);
        $this->createdAt = \Inttegro\ValueHydrator::dateTime($data['created_at'] ?? null, false);
        $this->updatedAt = \Inttegro\ValueHydrator::dateTime($data['updated_at'] ?? null, true);
        $this->archivedAt = \Inttegro\ValueHydrator::dateTime($data['archived_at'] ?? null, true);
    }

    /**
     * Creates a Price from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Price value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
