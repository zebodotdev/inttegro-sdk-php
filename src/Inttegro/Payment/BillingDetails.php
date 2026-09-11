<?php

namespace Inttegro\Payment;


/**
 * Billing Details details associated with payment.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class BillingDetails extends \Inttegro\DomainValue
{
    /**
     * Owner value for this billing details.
     *
     * Optional response field. PHP type: `\Inttegro\Payment\PaymentMethodOwner|null`; wire field:
     * `owner` (`object`).
     *
     * @var \Inttegro\Payment\PaymentMethodOwner|null
     */
    public readonly ?\Inttegro\Payment\PaymentMethodOwner $owner;

    /**
     * Hydrates a BillingDetails from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->owner = \Inttegro\ValueHydrator::object($data['owner'] ?? null, [\Inttegro\Payment\PaymentMethodOwner::class], true);
    }

    /**
     * Creates a BillingDetails from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable BillingDetails value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
