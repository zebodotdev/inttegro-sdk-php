<?php

namespace Inttegro\Product;

use DateTimeImmutable;

/**
 * Updated details associated with product.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Updated extends \Inttegro\DomainValue
{
    /**
     * Product identifier returned by the update operation.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Human-readable name.
     *
     * Required response field. PHP type: `string`; wire field: `name` (`string`).
     *
     * @var string
     */
    public readonly string $name;

    /**
     * Human-readable description.
     *
     * Optional response field. PHP type: `string|null`; wire field: `description` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $description;

    /**
     * Additional explanatory text.
     *
     * Optional response field. PHP type: `string|null`; wire field: `about` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $about;

    /**
     * Discriminator identifying the value's API variant.
     *
     * Required response field. PHP type: `string`; wire field: `type` (`string`).
     * Compare against `Type` cases by using their `->value` strings.
     *
     * @var string
     */
    public readonly string $type;

    /**
     * Reference value for this updated.
     *
     * Optional response field. PHP type: `string|null`; wire field: `reference` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $reference;

    /**
     * Tax Code value for this updated.
     *
     * Optional response field. PHP type: `string|null`; wire field: `tax_code` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $taxCode;

    /**
     * Category value for this updated.
     *
     * Optional response field. PHP type: `string|null`; wire field: `category` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $category;

    /**
     * Merchant-defined string values attached to a resource. SDKs expose this as a semantic
     * collection rather than a raw map.
     *
     * Optional response field. PHP type: `array<string, string>|null`; wire field: `custom_data`
     * (`object`).
     *
     * @var array<string, string>|null
     */
    public readonly ?array $customData;

    /**
     * At most one of `physical`, `digital`, or `custom`.
     *
     * Optional response field. PHP type: `\Inttegro\Product\Dimensions|null`; wire field:
     * `dimensions` (`object`).
     *
     * @var \Inttegro\Product\Dimensions|null
     */
    public readonly ?\Inttegro\Product\Dimensions $dimensions;

    /**
     * Prices value for this updated.
     *
     * Optional response field. PHP type: `list<\Inttegro\Product\PriceSummary>|null`; wire field:
     * `prices` (`array<object>`).
     * When the field is absent, the SDK exposes an empty collection.
     *
     * @var list<\Inttegro\Product\PriceSummary>|null
     */
    public readonly ?array $prices;

    /**
     * Unit Dim value for this updated.
     *
     * Optional response field. PHP type: `string|null`; wire field: `unit_dim` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $unitDim;

    /**
     * Time at which the value was created.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `created_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $createdAt;

    /**
     * Time at which the value was last updated.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `updated_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $updatedAt;

    /**
     * Hydrates an Updated from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->name = \Inttegro\ValueHydrator::string($data['name'] ?? null, false);
        $this->description = \Inttegro\ValueHydrator::string($data['description'] ?? null, true);
        $this->about = \Inttegro\ValueHydrator::string($data['about'] ?? null, true);
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
        $this->reference = \Inttegro\ValueHydrator::string($data['reference'] ?? null, true);
        $this->taxCode = \Inttegro\ValueHydrator::string($data['tax_code'] ?? null, true);
        $this->category = \Inttegro\ValueHydrator::string($data['category'] ?? null, true);
        $this->customData = \Inttegro\ValueHydrator::array($data['custom_data'] ?? null, true);
        $this->dimensions = \Inttegro\ValueHydrator::object($data['dimensions'] ?? null, [\Inttegro\Product\Dimensions::class], true);
        $this->prices = \Inttegro\ValueHydrator::objects($data['prices'] ?? null, [\Inttegro\Product\PriceSummary::class]);
        $this->unitDim = \Inttegro\ValueHydrator::string($data['unit_dim'] ?? null, true);
        $this->createdAt = \Inttegro\ValueHydrator::dateTime($data['created_at'] ?? null, false);
        $this->updatedAt = \Inttegro\ValueHydrator::dateTime($data['updated_at'] ?? null, true);
    }

    /**
     * Creates an Updated from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Updated value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
