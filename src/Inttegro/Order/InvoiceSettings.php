<?php

namespace Inttegro\Order;


/**
 * Order-level invoice rendering data. Pages uses this data when rendering invoice web and download
 * views.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class InvoiceSettings extends \Inttegro\DomainValue
{
    /**
     * Optional invoice number. When omitted, invoice delivery falls back to the order number and
     * then the order ID for labels.
     *
     * Optional response field. PHP type: `string|null`; wire field: `number` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $number;

    /**
     * Optional invoice memo.
     *
     * Optional response field. PHP type: `string|null`; wire field: `memo` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $memo;

    /**
     * Optional invoice footer.
     *
     * Optional response field. PHP type: `string|null`; wire field: `footer` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $footer;

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
     * Hydrates an InvoiceSettings from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->number = \Inttegro\ValueHydrator::string($data['number'] ?? null, true);
        $this->memo = \Inttegro\ValueHydrator::string($data['memo'] ?? null, true);
        $this->footer = \Inttegro\ValueHydrator::string($data['footer'] ?? null, true);
        $this->customData = \Inttegro\ValueHydrator::array($data['custom_data'] ?? null, true);
    }

    /**
     * Creates an InvoiceSettings from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable InvoiceSettings value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
