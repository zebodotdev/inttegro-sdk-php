<?php

namespace Inttegro\Order;


/**
 * Document Format details associated with order.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class DocumentFormat extends \Inttegro\DomainValue
{
    /**
     * URL value for this document format.
     *
     * Required response field. PHP type: `string`; wire field: `url` (`string`).
     *
     * @var string
     */
    public readonly string $url;

    /**
     * Hydrates a DocumentFormat from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->url = \Inttegro\ValueHydrator::string($data['url'] ?? null, false);
    }

    /**
     * Creates a DocumentFormat from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable DocumentFormat value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
