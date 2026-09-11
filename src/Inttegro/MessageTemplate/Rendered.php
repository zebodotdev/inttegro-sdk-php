<?php

namespace Inttegro\MessageTemplate;


/**
 * Rendered details associated with message template.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Rendered extends \Inttegro\DomainValue
{
    /**
     * Channel value for this rendered.
     *
     * Required response field. PHP type: `string`; wire field: `channel` (`string`).
     * Compare against `Channel` cases by using their `->value` strings.
     *
     * @var string
     */
    public readonly string $channel;

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
     * SMS value for this rendered.
     *
     * Optional response field. PHP type: `\Inttegro\MessageTemplate\RenderedSMS|null`; wire field:
     * `sms` (`object`).
     *
     * @var \Inttegro\MessageTemplate\RenderedSMS|null
     */
    public readonly ?\Inttegro\MessageTemplate\RenderedSMS $sms;

    /**
     * Email value for this rendered.
     *
     * Optional response field. PHP type: `\Inttegro\MessageTemplate\RenderedEmail|null`; wire
     * field: `email` (`object`).
     *
     * @var \Inttegro\MessageTemplate\RenderedEmail|null
     */
    public readonly ?\Inttegro\MessageTemplate\RenderedEmail $email;

    /**
     * Hydrates a Rendered from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->channel = \Inttegro\ValueHydrator::string($data['channel'] ?? null, false);
        $this->attachments = \Inttegro\ValueHydrator::object($data['attachments'] ?? null, [\Inttegro\GenericValue::class], true);
        $this->sms = \Inttegro\ValueHydrator::object($data['sms'] ?? null, [\Inttegro\MessageTemplate\RenderedSMS::class], true);
        $this->email = \Inttegro\ValueHydrator::object($data['email'] ?? null, [\Inttegro\MessageTemplate\RenderedEmail::class], true);
    }

    /**
     * Creates a Rendered from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Rendered value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
