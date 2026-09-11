<?php

namespace Inttegro\SecretKey;


/**
 * A page of secret key values together with pagination metadata.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class UsagePage extends \Inttegro\DomainValue
{
    /**
     * Page or business reference number, as defined by the containing value.
     *
     * Required response field. PHP type: `int`; wire field: `number` (`integer`).
     *
     * @var int
     */
    public readonly int $number;

    /**
     * Size value for this usage page.
     *
     * Required response field. PHP type: `int`; wire field: `size` (`integer`).
     *
     * @var int
     */
    public readonly int $size;

    /**
     * Count value for this usage page.
     *
     * Required response field. PHP type: `int`; wire field: `count` (`integer`).
     *
     * @var int
     */
    public readonly int $count;

    /**
     * Total number of matching values.
     *
     * Required response field. PHP type: `int`; wire field: `total` (`integer`).
     *
     * @var int
     */
    public readonly int $total;

    /**
     * Has More value for this usage page.
     *
     * Required response field. PHP type: `bool`; wire field: `has_more` (`boolean`).
     *
     * @var bool
     */
    public readonly bool $hasMore;

    /**
     * Rows value for this usage page.
     *
     * Required response field. PHP type: `list<\Inttegro\SecretKey\UsageRow>`; wire field: `rows`
     * (`array<object>`).
     * When the field is absent, the SDK exposes an empty collection.
     *
     * @var list<\Inttegro\SecretKey\UsageRow>
     */
    public readonly array $rows;

    /**
     * Hydrates an UsagePage from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->number = \Inttegro\ValueHydrator::int($data['number'] ?? null, false);
        $this->size = \Inttegro\ValueHydrator::int($data['size'] ?? null, false);
        $this->count = \Inttegro\ValueHydrator::int($data['count'] ?? null, false);
        $this->total = \Inttegro\ValueHydrator::int($data['total'] ?? null, false);
        $this->hasMore = \Inttegro\ValueHydrator::bool($data['has_more'] ?? null, false);
        $this->rows = \Inttegro\ValueHydrator::objects($data['rows'] ?? null, [\Inttegro\SecretKey\UsageRow::class]);
    }

    /**
     * Creates an UsagePage from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable UsagePage value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
