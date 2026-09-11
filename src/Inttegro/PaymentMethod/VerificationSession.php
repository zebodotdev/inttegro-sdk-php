<?php

namespace Inttegro\PaymentMethod;

use DateTimeImmutable;

/**
 * A payment-method verification session, including token delivery and expiry state.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class VerificationSession extends \Inttegro\DomainValue
{
    /**
     * Identifier of the related payment method.
     *
     * Required response field. PHP type: `string`; wire field: `payment_method_id` (`string`).
     *
     * @var string
     */
    public readonly string $paymentMethodId;

    /**
     * Current lifecycle state.
     *
     * Required response field. PHP type: `string`; wire field: `status` (`string`).
     *
     * @var string
     */
    public readonly string $status;

    /**
     * Timestamp associated with token sent.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `token_sent_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $tokenSentAt;

    /**
     * Timestamp associated with expires.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `expires_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $expiresAt;

    /**
     * Delivery value for this verification session.
     *
     * Optional response field. PHP type: `\Inttegro\PaymentMethod\VerificationDelivery|null`; wire
     * field: `delivery` (`object`).
     *
     * @var \Inttegro\PaymentMethod\VerificationDelivery|null
     */
    public readonly ?\Inttegro\PaymentMethod\VerificationDelivery $delivery;

    /**
     * Hydrates a VerificationSession from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->paymentMethodId = \Inttegro\ValueHydrator::string($data['payment_method_id'] ?? null, false);
        $this->status = \Inttegro\ValueHydrator::string($data['status'] ?? null, false);
        $this->tokenSentAt = \Inttegro\ValueHydrator::dateTime($data['token_sent_at'] ?? null, true);
        $this->expiresAt = \Inttegro\ValueHydrator::dateTime($data['expires_at'] ?? null, true);
        $this->delivery = \Inttegro\ValueHydrator::object($data['delivery'] ?? null, [\Inttegro\PaymentMethod\VerificationDelivery::class], true);
    }

    /**
     * Creates a VerificationSession from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable VerificationSession value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
