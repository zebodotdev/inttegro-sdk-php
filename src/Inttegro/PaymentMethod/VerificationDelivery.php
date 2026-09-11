<?php

namespace Inttegro\PaymentMethod;


/**
 * Verification Delivery details associated with payment method.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class VerificationDelivery extends \Inttegro\DomainValue
{
    /**
     * Recipient value for this verification delivery.
     *
     * Optional response field. PHP type: `string|null`; wire field: `recipient` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $recipient;

    /**
     * Channel value for this verification delivery.
     *
     * Optional response field. PHP type: `string|null`; wire field: `channel` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $channel;

    /**
     * Identifier of the related sender.
     *
     * Optional response field. PHP type: `string|null`; wire field: `sender_id` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $senderId;

    /**
     * Hydrates a VerificationDelivery from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->recipient = \Inttegro\ValueHydrator::string($data['recipient'] ?? null, true);
        $this->channel = \Inttegro\ValueHydrator::string($data['channel'] ?? null, true);
        $this->senderId = \Inttegro\ValueHydrator::string($data['sender_id'] ?? null, true);
    }

    /**
     * Creates a VerificationDelivery from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable VerificationDelivery value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
