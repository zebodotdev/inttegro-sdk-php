<?php

namespace Inttegro\Price;

use DateTimeImmutable;

/**
 * Embedded Product details associated with price.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class EmbeddedProduct extends \Inttegro\DomainValue
{
    /**
     * Unique product identifier with prod_ prefix.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Full product description.
     *
     * Optional response field. PHP type: `string|null`; wire field: `about` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $about;

    /**
     * Whether product is published and available.
     *
     * Required response field. PHP type: `bool`; wire field: `active` (`boolean`).
     *
     * @var bool
     */
    public readonly bool $active;

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
     * Product attributes.
     *
     * Optional response field. PHP type:
     * `list<\Inttegro\Price\EmbeddedProductAttributesItem>|null`; wire field: `attributes`
     * (`array<object>`).
     * When the field is absent, the SDK exposes an empty collection.
     *
     * @var list<\Inttegro\Price\EmbeddedProductAttributesItem>|null
     */
    public readonly ?array $attributes;

    /**
     * Product category.
     *
     * Optional response field. PHP type: `string|null`; wire field: `category` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $category;

    /**
     * Product creation timestamp.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `created_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $createdAt;

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
     * Short description.
     *
     * Optional response field. PHP type: `string|null`; wire field: `description` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $description;

    /**
     * Product dimensions and size metadata.
     *
     * Optional response field. PHP type: `\Inttegro\Product\Dimensions|null`; wire field:
     * `dimensions` (`object`).
     *
     * @var \Inttegro\Product\Dimensions|null
     */
    public readonly ?\Inttegro\Product\Dimensions $dimensions;

    /**
     * Product media assets.
     *
     * Optional response field. PHP type: `\Inttegro\Product\Media|null`; wire field: `media`
     * (`object`).
     *
     * @var \Inttegro\Product\Media|null
     */
    public readonly ?\Inttegro\Product\Media $media;

    /**
     * Product name.
     *
     * Required response field. PHP type: `string`; wire field: `name` (`string`).
     *
     * @var string
     */
    public readonly string $name;

    /**
     * When the product was published.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `published_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $publishedAt;

    /**
     * External reference or SKU.
     *
     * Optional response field. PHP type: `string|null`; wire field: `reference` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $reference;

    /**
     * Shipment and fulfillment details.
     *
     * Optional response field. PHP type: `\Inttegro\Product\Shipment|null`; wire field: `shipment`
     * (`object`).
     *
     * @var \Inttegro\Product\Shipment|null
     */
    public readonly ?\Inttegro\Product\Shipment $shipment;

    /**
     * Tax classification code.
     *
     * Optional response field. PHP type: `string|null`; wire field: `tax_code` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $taxCode;

    /**
     * Product type.
     *
     * Required response field. PHP type: `string`; wire field: `type` (`string`).
     *
     * @var string
     */
    public readonly string $type;

    /**
     * Unit dimension label.
     *
     * Optional response field. PHP type: `string|null`; wire field: `unit_dim` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $unitDim;

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
     * Hydrates an EmbeddedProduct from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->about = \Inttegro\ValueHydrator::string($data['about'] ?? null, true);
        $this->active = \Inttegro\ValueHydrator::bool($data['active'] ?? null, false);
        $this->archivedAt = \Inttegro\ValueHydrator::dateTime($data['archived_at'] ?? null, true);
        $this->attributes = \Inttegro\ValueHydrator::objects($data['attributes'] ?? null, [\Inttegro\Price\EmbeddedProductAttributesItem::class]);
        $this->category = \Inttegro\ValueHydrator::string($data['category'] ?? null, true);
        $this->createdAt = \Inttegro\ValueHydrator::dateTime($data['created_at'] ?? null, false);
        $this->customData = \Inttegro\ValueHydrator::array($data['custom_data'] ?? null, true);
        $this->description = \Inttegro\ValueHydrator::string($data['description'] ?? null, true);
        $this->dimensions = \Inttegro\ValueHydrator::object($data['dimensions'] ?? null, [\Inttegro\Product\Dimensions::class], true);
        $this->media = \Inttegro\ValueHydrator::object($data['media'] ?? null, [\Inttegro\Product\Media::class], true);
        $this->name = \Inttegro\ValueHydrator::string($data['name'] ?? null, false);
        $this->publishedAt = \Inttegro\ValueHydrator::dateTime($data['published_at'] ?? null, true);
        $this->reference = \Inttegro\ValueHydrator::string($data['reference'] ?? null, true);
        $this->shipment = \Inttegro\ValueHydrator::object($data['shipment'] ?? null, [\Inttegro\Product\Shipment::class], true);
        $this->taxCode = \Inttegro\ValueHydrator::string($data['tax_code'] ?? null, true);
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
        $this->unitDim = \Inttegro\ValueHydrator::string($data['unit_dim'] ?? null, true);
        $this->updatedAt = \Inttegro\ValueHydrator::dateTime($data['updated_at'] ?? null, true);
    }

    /**
     * Creates an EmbeddedProduct from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable EmbeddedProduct value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
