<?php

namespace Inttegro\Chime;


/**
 * Email content, safety scan result, and system-generated schema markup for email chimes.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class EmailMessage extends \Inttegro\DomainValue
{
    /**
     * Email subject.
     *
     * Optional response field. PHP type: `string|null`; wire field: `subject` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $subject;

    /**
     * Plain-text email body.
     *
     * Optional response field. PHP type: `string|null`; wire field: `text` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $text;

    /**
     * Optional HTML email body before provider-specific rendering.
     *
     * Optional response field. PHP type: `string|null`; wire field: `html` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $html;

    /**
     * From value for this email message.
     *
     * Optional response field. PHP type: `\Inttegro\Chime\EmailMailbox|null`; wire field: `from_`
     * (`object`).
     *
     * @var \Inttegro\Chime\EmailMailbox|null
     */
    public readonly ?\Inttegro\Chime\EmailMailbox $from;

    /**
     * Reply To value for this email message.
     *
     * Optional response field. PHP type: `\Inttegro\Chime\EmailMailbox|null`; wire field:
     * `reply_to` (`object`).
     *
     * @var \Inttegro\Chime\EmailMailbox|null
     */
    public readonly ?\Inttegro\Chime\EmailMailbox $replyTo;

    /**
     * Validated provider-neutral email headers.
     *
     * Optional response field. PHP type: `array<string, string>|null`; wire field: `headers`
     * (`object`).
     *
     * @var array<string, string>|null
     */
    public readonly ?array $headers;

    /**
     * Result of the email safety scan.
     *
     * Optional response field. PHP type: `\Inttegro\Chime\EmailSafetyResult|null`; wire field:
     * `safety` (`object`).
     *
     * @var \Inttegro\Chime\EmailSafetyResult|null
     */
    public readonly ?\Inttegro\Chime\EmailSafetyResult $safety;

    /**
     * Schema.org JSON-LD markup generated at email send time.
     *
     * Optional response field. PHP type: `\Inttegro\Chime\EmailSchemaMarkup|null`; wire field:
     * `schema` (`object`).
     *
     * @var \Inttegro\Chime\EmailSchemaMarkup|null
     */
    public readonly ?\Inttegro\Chime\EmailSchemaMarkup $schema;

    /**
     * Hydrates an EmailMessage from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->subject = \Inttegro\ValueHydrator::string($data['subject'] ?? null, true);
        $this->text = \Inttegro\ValueHydrator::string($data['text'] ?? null, true);
        $this->html = \Inttegro\ValueHydrator::string($data['html'] ?? null, true);
        $this->from = \Inttegro\ValueHydrator::object($data['from_'] ?? null, [\Inttegro\Chime\EmailMailbox::class], true);
        $this->replyTo = \Inttegro\ValueHydrator::object($data['reply_to'] ?? null, [\Inttegro\Chime\EmailMailbox::class], true);
        $this->headers = \Inttegro\ValueHydrator::array($data['headers'] ?? null, true);
        $this->safety = \Inttegro\ValueHydrator::object($data['safety'] ?? null, [\Inttegro\Chime\EmailSafetyResult::class], true);
        $this->schema = \Inttegro\ValueHydrator::object($data['schema'] ?? null, [\Inttegro\Chime\EmailSchemaMarkup::class], true);
    }

    /**
     * Creates an EmailMessage from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable EmailMessage value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
