<?php

namespace Inttegro\Payment;

use DateTimeImmutable;

/**
 * Details for requesting a fresh customer confirmation.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class NextActionRequestConfirmation extends \Inttegro\DomainValue
{
    /**
     * Last Request value for this next action request confirmation.
     *
     * Optional response field. PHP type: `\Inttegro\Payment\NextActionConfirmPaymentRequest|null`;
     * wire field: `last_request` (`object`).
     *
     * @var \Inttegro\Payment\NextActionConfirmPaymentRequest|null
     */
    public readonly ?\Inttegro\Payment\NextActionConfirmPaymentRequest $lastRequest;

    /**
     * After value for this next action request confirmation.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `after` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $after;

    /**
     * Hydrates a NextActionRequestConfirmation from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->lastRequest = \Inttegro\ValueHydrator::object($data['last_request'] ?? null, [\Inttegro\Payment\NextActionConfirmPaymentRequest::class], true);
        $this->after = \Inttegro\ValueHydrator::dateTime($data['after'] ?? null, true);
    }

    /**
     * Creates a NextActionRequestConfirmation from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable NextActionRequestConfirmation value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
