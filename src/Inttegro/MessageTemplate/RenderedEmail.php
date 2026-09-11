<?php

namespace Inttegro\MessageTemplate;


/**
 * Rendered Email details associated with message template.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class RenderedEmail extends \Inttegro\DomainValue
{
    /**
     * Subject value for this rendered email.
     *
     * Required response field. PHP type: `string`; wire field: `subject` (`string`).
     *
     * @var string
     */
    public readonly string $subject;

    /**
     * Text value for this rendered email.
     *
     * Required response field. PHP type: `string`; wire field: `text` (`string`).
     *
     * @var string
     */
    public readonly string $text;

    /**
     * Html value for this rendered email.
     *
     * Optional response field. PHP type: `string|null`; wire field: `html` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $html;

    /**
     * From value for this rendered email.
     *
     * Optional response field. PHP type: `\Inttegro\MessageTemplate\Mailbox|null`; wire field:
     * `from_` (`object`).
     *
     * @var \Inttegro\MessageTemplate\Mailbox|null
     */
    public readonly ?\Inttegro\MessageTemplate\Mailbox $from;

    /**
     * Reply To value for this rendered email.
     *
     * Optional response field. PHP type: `\Inttegro\MessageTemplate\Mailbox|null`; wire field:
     * `reply_to` (`object`).
     *
     * @var \Inttegro\MessageTemplate\Mailbox|null
     */
    public readonly ?\Inttegro\MessageTemplate\Mailbox $replyTo;

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
     * Optional response field. PHP type: `\Inttegro\MessageTemplate\SafetyResult|null`; wire field:
     * `safety` (`object`).
     *
     * @var \Inttegro\MessageTemplate\SafetyResult|null
     */
    public readonly ?\Inttegro\MessageTemplate\SafetyResult $safety;

    /**
     * Hydrates a RenderedEmail from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->subject = \Inttegro\ValueHydrator::string($data['subject'] ?? null, false);
        $this->text = \Inttegro\ValueHydrator::string($data['text'] ?? null, false);
        $this->html = \Inttegro\ValueHydrator::string($data['html'] ?? null, true);
        $this->from = \Inttegro\ValueHydrator::object($data['from_'] ?? null, [\Inttegro\MessageTemplate\Mailbox::class], true);
        $this->replyTo = \Inttegro\ValueHydrator::object($data['reply_to'] ?? null, [\Inttegro\MessageTemplate\Mailbox::class], true);
        $this->headers = \Inttegro\ValueHydrator::array($data['headers'] ?? null, true);
        $this->safety = \Inttegro\ValueHydrator::object($data['safety'] ?? null, [\Inttegro\MessageTemplate\SafetyResult::class], true);
    }

    /**
     * Creates a RenderedEmail from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable RenderedEmail value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
