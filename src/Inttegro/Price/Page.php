<?php

namespace Inttegro\Price;


/**
 * A page of price values together with pagination metadata.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Page extends \Inttegro\DomainValue
{
    /**
     * The page number returned.
     *
     * Optional response field. PHP type: `int|null`; wire field: `number` (`integer`).
     *
     * @var int|null
     */
    public readonly ?int $number;

    /**
     * The number of prices in this page.
     *
     * Optional response field. PHP type: `int|null`; wire field: `size` (`integer`).
     *
     * @var int|null
     */
    public readonly ?int $size;

    /**
     * Prices value for this page.
     *
     * Optional response field. PHP type: `list<\Inttegro\Price\Price>|null`; wire field: `prices`
     * (`array<object>`).
     * When the field is absent, the SDK exposes an empty collection.
     *
     * @var list<\Inttegro\Price\Price>|null
     */
    public readonly ?array $prices;

    /**
     * Hydrates a Page from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->number = \Inttegro\ValueHydrator::int($data['number'] ?? null, true);
        $this->size = \Inttegro\ValueHydrator::int($data['size'] ?? null, true);
        $this->prices = \Inttegro\ValueHydrator::objects($data['prices'] ?? null, [\Inttegro\Price\Price::class]);
    }

    /**
     * Creates a Page from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Page value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
