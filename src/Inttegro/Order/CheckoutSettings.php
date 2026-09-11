<?php

namespace Inttegro\Order;


/**
 * Checkout and payment flow configuration. Strongly recommended to provide both redirect_url and
 * cancel_url for a delightful customer experience.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class CheckoutSettings extends \Inttegro\DomainValue
{
    /**
     * URL to redirect customer after payment completion.
     *
     * Optional response field. PHP type: `string|null`; wire field: `redirect_url` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $redirectUrl;

    /**
     * URL to redirect customer if they cancel payment.
     *
     * Optional response field. PHP type: `string|null`; wire field: `cancel_url` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $cancelUrl;

    /**
     * Hydrates a CheckoutSettings from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->redirectUrl = \Inttegro\ValueHydrator::string($data['redirect_url'] ?? null, true);
        $this->cancelUrl = \Inttegro\ValueHydrator::string($data['cancel_url'] ?? null, true);
    }

    /**
     * Creates a CheckoutSettings from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable CheckoutSettings value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
