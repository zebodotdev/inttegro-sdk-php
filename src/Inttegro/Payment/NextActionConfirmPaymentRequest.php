<?php

namespace Inttegro\Payment;


/**
 * Next Action Confirm Payment Request details associated with payment.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class NextActionConfirmPaymentRequest extends \Inttegro\DomainValue
{
    /**
     * Unique identifier for this next action confirm payment request.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Recipient value for this next action confirm payment request.
     *
     * Required response field. PHP type: `string`; wire field: `recipient` (`string`).
     *
     * @var string
     */
    public readonly string $recipient;

    /**
     * Sent Via value for this next action confirm payment request.
     *
     * Required response field. PHP type: `string`; wire field: `sent_via` (`string`).
     *
     * @var string
     */
    public readonly string $sentVia;

    /**
     * Token Size value for this next action confirm payment request.
     *
     * Required response field. PHP type: `int`; wire field: `token_size` (`integer`).
     *
     * @var int
     */
    public readonly int $tokenSize;

    /**
     * Identifier of the related sender.
     *
     * Required response field. PHP type: `string`; wire field: `sender_id` (`string`).
     *
     * @var string
     */
    public readonly string $senderId;

    /**
     * Current lifecycle state.
     *
     * Optional response field. PHP type: `string|null`; wire field: `status` (`string`).
     * Compare against `Status` cases by using their `->value` strings.
     *
     * @var string|null
     */
    public readonly ?string $status;

    /**
     * Hydrates a NextActionConfirmPaymentRequest from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->recipient = \Inttegro\ValueHydrator::string($data['recipient'] ?? null, false);
        $this->sentVia = \Inttegro\ValueHydrator::string($data['sent_via'] ?? null, false);
        $this->tokenSize = \Inttegro\ValueHydrator::int($data['token_size'] ?? null, false);
        $this->senderId = \Inttegro\ValueHydrator::string($data['sender_id'] ?? null, false);
        $this->status = \Inttegro\ValueHydrator::string($data['status'] ?? null, true);
    }

    /**
     * Creates a NextActionConfirmPaymentRequest from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable NextActionConfirmPaymentRequest value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
