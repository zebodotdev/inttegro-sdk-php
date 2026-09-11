<?php

namespace Inttegro\MessageTemplate;

use DateTimeImmutable;

/**
 * A reusable SMS or email template, including its variables, content, safety results, and lifecycle
 * state.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class MessageTemplate extends \Inttegro\DomainValue
{
    /**
     * API-generated unique template id.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Human-readable name.
     *
     * Required response field. PHP type: `string`; wire field: `name` (`string`).
     *
     * @var string
     */
    public readonly string $name;

    /**
     * Additional explanatory text.
     *
     * Optional response field. PHP type: `string|null`; wire field: `about` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $about;

    /**
     * Channel value for this message template.
     *
     * Required response field. PHP type: `string`; wire field: `channel` (`string`).
     * Compare against `Channel` cases by using their `->value` strings.
     *
     * @var string
     */
    public readonly string $channel;

    /**
     * Purpose value for this message template.
     *
     * Required response field. PHP type: `string`; wire field: `purpose` (`string`).
     *
     * @var string
     */
    public readonly string $purpose;

    /**
     * Locale value for this message template.
     *
     * Required response field. PHP type: `string`; wire field: `locale` (`string`).
     *
     * @var string
     */
    public readonly string $locale;

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
     * Version value for this message template.
     *
     * Required response field. PHP type: `int`; wire field: `version` (`integer`).
     *
     * @var int
     */
    public readonly int $version;

    /**
     * Published Version value for this message template.
     *
     * Optional response field. PHP type: `int|null`; wire field: `published_version` (`integer`).
     *
     * @var int|null
     */
    public readonly ?int $publishedVersion;

    /**
     * Draft Version value for this message template.
     *
     * Required response field. PHP type: `int`; wire field: `draft_version` (`integer`).
     *
     * @var int
     */
    public readonly int $draftVersion;

    /**
     * Has Unpublished Changes value for this message template.
     *
     * Required response field. PHP type: `bool`; wire field: `has_unpublished_changes` (`boolean`).
     *
     * @var bool
     */
    public readonly bool $hasUnpublishedChanges;

    /**
     * Variables value for this message template.
     *
     * Optional response field. PHP type: `list<\Inttegro\MessageTemplate\Variable>|null`; wire
     * field: `variables` (`array<object>`).
     * When the field is absent, the SDK exposes an empty collection.
     *
     * @var list<\Inttegro\MessageTemplate\Variable>|null
     */
    public readonly ?array $variables;

    /**
     * SMS value for this message template.
     *
     * Optional response field. PHP type: `\Inttegro\MessageTemplate\SMSContent|null`; wire field:
     * `sms` (`object`).
     *
     * @var \Inttegro\MessageTemplate\SMSContent|null
     */
    public readonly ?\Inttegro\MessageTemplate\SMSContent $sms;

    /**
     * Email value for this message template.
     *
     * Optional response field. PHP type: `\Inttegro\MessageTemplate\EmailContent|null`; wire field:
     * `email` (`object`).
     *
     * @var \Inttegro\MessageTemplate\EmailContent|null
     */
    public readonly ?\Inttegro\MessageTemplate\EmailContent $email;

    /**
     * Stored file IDs returned by previews. Chime send, schedule, and broadcast currently reject
     * stored-template attachments.
     *
     * Optional response field. PHP type: `\Inttegro\GenericValue|null`; wire field: `attachments`
     * (`array<string>`).
     *
     * @var \Inttegro\GenericValue|null
     */
    public readonly ?\Inttegro\GenericValue $attachments;

    /**
     * Time at which the value was created.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `created_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $createdAt;

    /**
     * Time at which the value was last updated.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `updated_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $updatedAt;

    /**
     * Time at which the value was published.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `published_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $publishedAt;

    /**
     * Time at which the value was archived.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `archived_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $archivedAt;

    /**
     * Hydrates a MessageTemplate from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->name = \Inttegro\ValueHydrator::string($data['name'] ?? null, false);
        $this->about = \Inttegro\ValueHydrator::string($data['about'] ?? null, true);
        $this->channel = \Inttegro\ValueHydrator::string($data['channel'] ?? null, false);
        $this->purpose = \Inttegro\ValueHydrator::string($data['purpose'] ?? null, false);
        $this->locale = \Inttegro\ValueHydrator::string($data['locale'] ?? null, false);
        $this->status = \Inttegro\ValueHydrator::string($data['status'] ?? null, false);
        $this->version = \Inttegro\ValueHydrator::int($data['version'] ?? null, false);
        $this->publishedVersion = \Inttegro\ValueHydrator::int($data['published_version'] ?? null, true);
        $this->draftVersion = \Inttegro\ValueHydrator::int($data['draft_version'] ?? null, false);
        $this->hasUnpublishedChanges = \Inttegro\ValueHydrator::bool($data['has_unpublished_changes'] ?? null, false);
        $this->variables = \Inttegro\ValueHydrator::objects($data['variables'] ?? null, [\Inttegro\MessageTemplate\Variable::class]);
        $this->sms = \Inttegro\ValueHydrator::object($data['sms'] ?? null, [\Inttegro\MessageTemplate\SMSContent::class], true);
        $this->email = \Inttegro\ValueHydrator::object($data['email'] ?? null, [\Inttegro\MessageTemplate\EmailContent::class], true);
        $this->attachments = \Inttegro\ValueHydrator::object($data['attachments'] ?? null, [\Inttegro\GenericValue::class], true);
        $this->createdAt = \Inttegro\ValueHydrator::dateTime($data['created_at'] ?? null, false);
        $this->updatedAt = \Inttegro\ValueHydrator::dateTime($data['updated_at'] ?? null, false);
        $this->publishedAt = \Inttegro\ValueHydrator::dateTime($data['published_at'] ?? null, true);
        $this->archivedAt = \Inttegro\ValueHydrator::dateTime($data['archived_at'] ?? null, true);
    }

    /**
     * Creates a MessageTemplate from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable MessageTemplate value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
