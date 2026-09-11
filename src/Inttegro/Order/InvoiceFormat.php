<?php

namespace Inttegro\Order;


/**
 * Invoice Format details associated with order.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class InvoiceFormat extends \Inttegro\DomainValue
{
    /**
     * Web value for this invoice format.
     *
     * Required response field. PHP type: `\Inttegro\Order\DocumentFormat`; wire field: `web`
     * (`object`).
     *
     * @var \Inttegro\Order\DocumentFormat
     */
    public readonly \Inttegro\Order\DocumentFormat $web;

    /**
     * Pdf value for this invoice format.
     *
     * Required response field. PHP type: `\Inttegro\Order\DocumentFormat`; wire field: `pdf`
     * (`object`).
     *
     * @var \Inttegro\Order\DocumentFormat
     */
    public readonly \Inttegro\Order\DocumentFormat $pdf;

    /**
     * Receipt value for this invoice format.
     *
     * Optional response field. PHP type: `\Inttegro\Order\DocumentFormat|null`; wire field:
     * `receipt` (`object`).
     *
     * @var \Inttegro\Order\DocumentFormat|null
     */
    public readonly ?\Inttegro\Order\DocumentFormat $receipt;

    /**
     * Hydrates an InvoiceFormat from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->web = \Inttegro\ValueHydrator::object($data['web'] ?? null, [\Inttegro\Order\DocumentFormat::class], false);
        $this->pdf = \Inttegro\ValueHydrator::object($data['pdf'] ?? null, [\Inttegro\Order\DocumentFormat::class], false);
        $this->receipt = \Inttegro\ValueHydrator::object($data['receipt'] ?? null, [\Inttegro\Order\DocumentFormat::class], true);
    }

    /**
     * Creates an InvoiceFormat from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable InvoiceFormat value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
