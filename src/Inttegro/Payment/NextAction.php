<?php

namespace Inttegro\Payment;


/**
 * Next action required to complete a payment.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class NextAction extends \Inttegro\DomainValue
{
    /**
     * Type of action required.
     *
     * Required response field. PHP type: `string`; wire field: `type` (`string`).
     *
     * @var string
     */
    public readonly string $type;

    /**
     * Details for customer payment confirmation.
     *
     * Optional response field. PHP type: `\Inttegro\Payment\NextActionConfirmPayment|null`; wire
     * field: `confirm_payment` (`object`).
     *
     * @var \Inttegro\Payment\NextActionConfirmPayment|null
     */
    public readonly ?\Inttegro\Payment\NextActionConfirmPayment $confirmPayment;

    /**
     * Details for redirect action.
     *
     * Optional response field. PHP type: `\Inttegro\Payment\NextActionRedirect|null`; wire field:
     * `redirect` (`object`).
     *
     * @var \Inttegro\Payment\NextActionRedirect|null
     */
    public readonly ?\Inttegro\Payment\NextActionRedirect $redirect;

    /**
     * Details for authorization action.
     *
     * Optional response field. PHP type: `\Inttegro\Payment\NextActionAuthorize|null`; wire field:
     * `authorize` (`object`).
     *
     * @var \Inttegro\Payment\NextActionAuthorize|null
     */
    public readonly ?\Inttegro\Payment\NextActionAuthorize $authorize;

    /**
     * Details for requesting a fresh customer confirmation.
     *
     * Optional response field. PHP type: `\Inttegro\Payment\NextActionRequestConfirmation|null`;
     * wire field: `request_confirmation` (`object`).
     *
     * @var \Inttegro\Payment\NextActionRequestConfirmation|null
     */
    public readonly ?\Inttegro\Payment\NextActionRequestConfirmation $requestConfirmation;

    /**
     * Hydrates a NextAction from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
        $this->confirmPayment = \Inttegro\ValueHydrator::object($data['confirm_payment'] ?? null, [\Inttegro\Payment\NextActionConfirmPayment::class], true);
        $this->redirect = \Inttegro\ValueHydrator::object($data['redirect'] ?? null, [\Inttegro\Payment\NextActionRedirect::class], true);
        $this->authorize = \Inttegro\ValueHydrator::object($data['authorize'] ?? null, [\Inttegro\Payment\NextActionAuthorize::class], true);
        $this->requestConfirmation = \Inttegro\ValueHydrator::object($data['request_confirmation'] ?? null, [\Inttegro\Payment\NextActionRequestConfirmation::class], true);
    }

    /**
     * Creates a NextAction from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable NextAction value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
