<?php

namespace Inttegro\Payment;

use DateTimeImmutable;

/**
 * Most recent payment attempt details.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Attempt extends \Inttegro\DomainValue
{
    /**
     * Payment Method Type value for this attempt.
     *
     * Optional response field. PHP type: `string|null`; wire field: `payment_method_type`
     * (`string`).
     *
     * @var string|null
     */
    public readonly ?string $paymentMethodType;

    /**
     * Identifier of the related payment method.
     *
     * Optional response field. PHP type: `string|null`; wire field: `payment_method_id` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $paymentMethodId;

    /**
     * Error value for this attempt.
     *
     * Optional response field. PHP type: `\Inttegro\Payment\AttemptError|null`; wire field: `error`
     * (`object`).
     *
     * @var \Inttegro\Payment\AttemptError|null
     */
    public readonly ?\Inttegro\Payment\AttemptError $error;

    /**
     * External payment reference.
     *
     * Optional response field. PHP type: `string|null`; wire field: `reference` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $reference;

    /**
     * Current lifecycle state.
     *
     * Required response field. PHP type: `string`; wire field: `status` (`string`).
     * Compare against `Status` cases by using their `->value` strings.
     *
     * @var string
     */
    public readonly string $status;

    /**
     * Time at which processing began.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `initiated_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $initiatedAt;

    /**
     * Timestamp associated with succeeded.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `succeeded_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $succeededAt;

    /**
     * Hydrates an Attempt from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->paymentMethodType = \Inttegro\ValueHydrator::string($data['payment_method_type'] ?? null, true);
        $this->paymentMethodId = \Inttegro\ValueHydrator::string($data['payment_method_id'] ?? null, true);
        $this->error = \Inttegro\ValueHydrator::object($data['error'] ?? null, [\Inttegro\Payment\AttemptError::class], true);
        $this->reference = \Inttegro\ValueHydrator::string($data['reference'] ?? null, true);
        $this->status = \Inttegro\ValueHydrator::string($data['status'] ?? null, false);
        $this->initiatedAt = \Inttegro\ValueHydrator::dateTime($data['initiated_at'] ?? null, false);
        $this->succeededAt = \Inttegro\ValueHydrator::dateTime($data['succeeded_at'] ?? null, true);
    }

    /**
     * Creates an Attempt from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Attempt value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
