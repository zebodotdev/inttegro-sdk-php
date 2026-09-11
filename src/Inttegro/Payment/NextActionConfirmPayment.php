<?php

namespace Inttegro\Payment;

use DateTimeImmutable;

/**
 * Details for customer payment confirmation.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class NextActionConfirmPayment extends \Inttegro\DomainValue
{
    /**
     * When the confirmation request expires.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `expires_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $expiresAt;

    /**
     * Authentication scheme used.
     *
     * Required response field. PHP type: `string`; wire field: `scheme` (`string`).
     *
     * @var string
     */
    public readonly string $scheme;

    /**
     * Confirmation request details.
     *
     * Optional response field. PHP type: `\Inttegro\Payment\NextActionConfirmPaymentRequest|null`;
     * wire field: `request` (`object`).
     *
     * @var \Inttegro\Payment\NextActionConfirmPaymentRequest|null
     */
    public readonly ?\Inttegro\Payment\NextActionConfirmPaymentRequest $request;

    /**
     * Latest confirmation attempt.
     *
     * Optional response field. PHP type: `\Inttegro\Payment\NextActionConfirmPaymentAttempt|null`;
     * wire field: `attempt` (`object`).
     *
     * @var \Inttegro\Payment\NextActionConfirmPaymentAttempt|null
     */
    public readonly ?\Inttegro\Payment\NextActionConfirmPaymentAttempt $attempt;

    /**
     * Whether the payment confirmation has completed.
     *
     * Required response field. PHP type: `bool`; wire field: `confirmed` (`boolean`).
     *
     * @var bool
     */
    public readonly bool $confirmed;

    /**
     * Confirmation status.
     *
     * Required response field. PHP type: `string`; wire field: `status` (`string`).
     * Compare against `Status` cases by using their `->value` strings.
     *
     * @var string
     */
    public readonly string $status;

    /**
     * Hydrates a NextActionConfirmPayment from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->expiresAt = \Inttegro\ValueHydrator::dateTime($data['expires_at'] ?? null, false);
        $this->scheme = \Inttegro\ValueHydrator::string($data['scheme'] ?? null, false);
        $this->request = \Inttegro\ValueHydrator::object($data['request'] ?? null, [\Inttegro\Payment\NextActionConfirmPaymentRequest::class], true);
        $this->attempt = \Inttegro\ValueHydrator::object($data['attempt'] ?? null, [\Inttegro\Payment\NextActionConfirmPaymentAttempt::class], true);
        $this->confirmed = \Inttegro\ValueHydrator::bool($data['confirmed'] ?? null, false);
        $this->status = \Inttegro\ValueHydrator::string($data['status'] ?? null, false);
    }

    /**
     * Creates a NextActionConfirmPayment from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable NextActionConfirmPayment value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
