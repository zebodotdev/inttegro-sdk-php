<?php

namespace Inttegro\PaymentMethod;


/**
 * A page of payment method values together with pagination metadata.
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
     * Required response field. PHP type: `int`; wire field: `number` (`integer`).
     *
     * @var int
     */
    public readonly int $number;

    /**
     * Payment Methods value for this page.
     *
     * Required response field. PHP type: `list<\Inttegro\PaymentMethod\PaymentMethod>`; wire field:
     * `payment_methods` (`array<object>`).
     * When the field is absent, the SDK exposes an empty collection.
     *
     * @var list<\Inttegro\PaymentMethod\PaymentMethod>
     */
    public readonly array $paymentMethods;

    /**
     * The number of payment methods in this page.
     *
     * Required response field. PHP type: `int`; wire field: `size` (`integer`).
     *
     * @var int
     */
    public readonly int $size;

    /**
     * Hydrates a Page from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->number = \Inttegro\ValueHydrator::int($data['number'] ?? null, false);
        $this->paymentMethods = \Inttegro\ValueHydrator::objects($data['payment_methods'] ?? null, [\Inttegro\PaymentMethod\PaymentMethod::class]);
        $this->size = \Inttegro\ValueHydrator::int($data['size'] ?? null, false);
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
