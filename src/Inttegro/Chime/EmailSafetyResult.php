<?php

namespace Inttegro\Chime;


/**
 * Result of the email safety scan.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class EmailSafetyResult extends \Inttegro\DomainValue
{
    /**
     * Safety decision for the email content.
     *
     * Optional response field. PHP type: `string|null`; wire field: `status` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $status;

    /**
     * Machine-readable reasons for non-allowed results.
     *
     * Optional response field. PHP type: `list<string>|null`; wire field: `reason_codes`
     * (`array<string>`).
     *
     * @var list<string>|null
     */
    public readonly ?array $reasonCodes;

    /**
     * Sanitized HTML body used for provider send when present.
     *
     * Optional response field. PHP type: `string|null`; wire field: `sanitized_html` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $sanitizedHtml;

    /**
     * Normalized plain-text body used by the scanner.
     *
     * Optional response field. PHP type: `string|null`; wire field: `normalized_text` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $normalizedText;

    /**
     * Links value for this email safety result.
     *
     * Optional response field. PHP type: `list<\Inttegro\Chime\EmailScannedLink>|null`; wire field:
     * `links` (`array<object>`).
     * When the field is absent, the SDK exposes an empty collection.
     *
     * @var list<\Inttegro\Chime\EmailScannedLink>|null
     */
    public readonly ?array $links;

    /**
     * Safety scanner identifier.
     *
     * Optional response field. PHP type: `string|null`; wire field: `scanner` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $scanner;

    /**
     * Hash of the scanned email content.
     *
     * Optional response field. PHP type: `string|null`; wire field: `content_hash` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $contentHash;

    /**
     * Quarantine Notes value for this email safety result.
     *
     * Optional response field. PHP type: `string|null`; wire field: `quarantine_notes` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $quarantineNotes;

    /**
     * Hydrates an EmailSafetyResult from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->status = \Inttegro\ValueHydrator::string($data['status'] ?? null, true);
        $this->reasonCodes = \Inttegro\ValueHydrator::array($data['reason_codes'] ?? null, true);
        $this->sanitizedHtml = \Inttegro\ValueHydrator::string($data['sanitized_html'] ?? null, true);
        $this->normalizedText = \Inttegro\ValueHydrator::string($data['normalized_text'] ?? null, true);
        $this->links = \Inttegro\ValueHydrator::objects($data['links'] ?? null, [\Inttegro\Chime\EmailScannedLink::class]);
        $this->scanner = \Inttegro\ValueHydrator::string($data['scanner'] ?? null, true);
        $this->contentHash = \Inttegro\ValueHydrator::string($data['content_hash'] ?? null, true);
        $this->quarantineNotes = \Inttegro\ValueHydrator::string($data['quarantine_notes'] ?? null, true);
    }

    /**
     * Creates an EmailSafetyResult from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable EmailSafetyResult value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
