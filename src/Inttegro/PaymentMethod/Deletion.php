<?php

namespace Inttegro\PaymentMethod;


/**
 * Deletion details associated with payment method.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Deletion extends \Inttegro\DomainValue
{
    /**
     * Deleted value for this deletion.
     *
     * Required response field. PHP type: `bool`; wire field: `deleted` (`boolean`).
     *
     * @var bool
     */
    public readonly bool $deleted;

    /**
     * ID of the payment method to fetch.
     *
     * Required response field. PHP type: `string`; wire field: `payment_method_id` (`string`).
     *
     * @var string
     */
    public readonly string $paymentMethodId;

    /**
     * Hydrates a Deletion from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->deleted = \Inttegro\ValueHydrator::bool($data['deleted'] ?? null, false);
        $this->paymentMethodId = \Inttegro\ValueHydrator::string($data['payment_method_id'] ?? null, false);
    }

    /**
     * Creates a Deletion from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Deletion value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
