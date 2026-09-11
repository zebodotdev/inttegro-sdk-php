<?php

namespace Inttegro\Order;


/**
 * Delivery result for one hosted order document link.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class DocumentDelivery extends \Inttegro\DomainValue
{
    /**
     * Chime messages that were accepted for delivery.
     *
     * Optional response field. PHP type: `list<\Inttegro\Order\DocumentDeliveryAttempt>|null`; wire
     * field: `deliveries` (`array<object>`).
     * When the field is absent, the SDK exposes an empty collection.
     *
     * @var list<\Inttegro\Order\DocumentDeliveryAttempt>|null
     */
    public readonly ?array $deliveries;

    /**
     * Hosted document that was delivered.
     *
     * Optional response field. PHP type: `string|null`; wire field: `document_kind` (`string`).
     * Compare against `DocumentKind` cases by using their `->value` strings.
     *
     * @var string|null
     */
    public readonly ?string $documentKind;

    /**
     * Hosted invoice or receipt URL sent to the customer. Receipt URLs use the hosted receipt path,
     * not the invoice PDF path.
     *
     * Optional response field. PHP type: `string|null`; wire field: `document_url` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $documentUrl;

    /**
     * Channels that failed to send.
     *
     * Optional response field. PHP type: `list<string>|null`; wire field: `failed_channels`
     * (`array<string>`).
     *
     * @var list<string>|null
     */
    public readonly ?array $failedChannels;

    /**
     * Per-channel delivery failures.
     *
     * Optional response field. PHP type: `list<\Inttegro\Order\DocumentDeliveryFailure>|null`; wire
     * field: `failures` (`array<object>`).
     * When the field is absent, the SDK exposes an empty collection.
     *
     * @var list<\Inttegro\Order\DocumentDeliveryFailure>|null
     */
    public readonly ?array $failures;

    /**
     * Channels accepted by Chime.
     *
     * Optional response field. PHP type: `list<string>|null`; wire field: `sent_channels`
     * (`array<string>`).
     *
     * @var list<string>|null
     */
    public readonly ?array $sentChannels;

    /**
     * Hydrates a DocumentDelivery from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->deliveries = \Inttegro\ValueHydrator::objects($data['deliveries'] ?? null, [\Inttegro\Order\DocumentDeliveryAttempt::class]);
        $this->documentKind = \Inttegro\ValueHydrator::string($data['document_kind'] ?? null, true);
        $this->documentUrl = \Inttegro\ValueHydrator::string($data['document_url'] ?? null, true);
        $this->failedChannels = \Inttegro\ValueHydrator::array($data['failed_channels'] ?? null, true);
        $this->failures = \Inttegro\ValueHydrator::objects($data['failures'] ?? null, [\Inttegro\Order\DocumentDeliveryFailure::class]);
        $this->sentChannels = \Inttegro\ValueHydrator::array($data['sent_channels'] ?? null, true);
    }

    /**
     * Creates a DocumentDelivery from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable DocumentDelivery value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
