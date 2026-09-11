<?php

namespace Inttegro\Order;


/**
 * Invoice details associated with order.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Invoice extends \Inttegro\DomainValue
{
    /**
     * Page or business reference number, as defined by the containing value.
     *
     * Optional response field. PHP type: `string|null`; wire field: `number` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $number;

    /**
     * Format value for this invoice.
     *
     * Required response field. PHP type: `\Inttegro\Order\InvoiceFormat`; wire field: `format`
     * (`object`).
     *
     * @var \Inttegro\Order\InvoiceFormat
     */
    public readonly \Inttegro\Order\InvoiceFormat $format;

    /**
     * Hydrates an Invoice from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->number = \Inttegro\ValueHydrator::string($data['number'] ?? null, true);
        $this->format = \Inttegro\ValueHydrator::object($data['format'] ?? null, [\Inttegro\Order\InvoiceFormat::class], false);
    }

    /**
     * Creates an Invoice from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Invoice value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
