<?php

namespace Inttegro\MessageTemplate;


/**
 * Result of the email safety scan.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class SafetyResult extends \Inttegro\DomainValue
{
    /**
     * Content Hash value for this safety result.
     *
     * Required response field. PHP type: `string`; wire field: `content_hash` (`string`).
     *
     * @var string
     */
    public readonly string $contentHash;

    /**
     * Links value for this safety result.
     *
     * Optional response field. PHP type: `list<\Inttegro\MessageTemplate\ScannedLink>|null`; wire
     * field: `links` (`array<object>`).
     * When the field is absent, the SDK exposes an empty collection.
     *
     * @var list<\Inttegro\MessageTemplate\ScannedLink>|null
     */
    public readonly ?array $links;

    /**
     * Normalized Text value for this safety result.
     *
     * Required response field. PHP type: `string`; wire field: `normalized_text` (`string`).
     *
     * @var string
     */
    public readonly string $normalizedText;

    /**
     * Quarantine Notes value for this safety result.
     *
     * Optional response field. PHP type: `string|null`; wire field: `quarantine_notes` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $quarantineNotes;

    /**
     * Reason Codes value for this safety result.
     *
     * Optional response field. PHP type: `list<string>|null`; wire field: `reason_codes`
     * (`array<string>`).
     *
     * @var list<string>|null
     */
    public readonly ?array $reasonCodes;

    /**
     * Sanitized Html value for this safety result.
     *
     * Optional response field. PHP type: `string|null`; wire field: `sanitized_html` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $sanitizedHtml;

    /**
     * Scanner value for this safety result.
     *
     * Required response field. PHP type: `string`; wire field: `scanner` (`string`).
     *
     * @var string
     */
    public readonly string $scanner;

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
     * Hydrates a SafetyResult from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->contentHash = \Inttegro\ValueHydrator::string($data['content_hash'] ?? null, false);
        $this->links = \Inttegro\ValueHydrator::objects($data['links'] ?? null, [\Inttegro\MessageTemplate\ScannedLink::class]);
        $this->normalizedText = \Inttegro\ValueHydrator::string($data['normalized_text'] ?? null, false);
        $this->quarantineNotes = \Inttegro\ValueHydrator::string($data['quarantine_notes'] ?? null, true);
        $this->reasonCodes = \Inttegro\ValueHydrator::array($data['reason_codes'] ?? null, true);
        $this->sanitizedHtml = \Inttegro\ValueHydrator::string($data['sanitized_html'] ?? null, true);
        $this->scanner = \Inttegro\ValueHydrator::string($data['scanner'] ?? null, false);
        $this->status = \Inttegro\ValueHydrator::string($data['status'] ?? null, false);
    }

    /**
     * Creates a SafetyResult from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable SafetyResult value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
