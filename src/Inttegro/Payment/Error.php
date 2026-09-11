<?php

namespace Inttegro\Payment;


/**
 * Structured failure details reported for payment.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Error extends \Inttegro\DomainValue
{
    /**
     * Message value for this error.
     *
     * Required response field. PHP type: `string`; wire field: `message` (`string`).
     *
     * @var string
     */
    public readonly string $message;

    /**
     * Docs URL value for this error.
     *
     * Required response field. PHP type: `string`; wire field: `docs_url` (`string`).
     *
     * @var string
     */
    public readonly string $docsUrl;

    /**
     * Source value for this error.
     *
     * Required response field. PHP type: `string`; wire field: `source` (`string`).
     *
     * @var string
     */
    public readonly string $source;

    /**
     * Discriminator identifying the value's API variant.
     *
     * Required response field. PHP type: `string`; wire field: `type` (`string`).
     *
     * @var string
     */
    public readonly string $type;

    /**
     * Code value for this error.
     *
     * Required response field. PHP type: `string`; wire field: `code` (`string`).
     *
     * @var string
     */
    public readonly string $code;

    /**
     * Hydrates an Error from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->message = \Inttegro\ValueHydrator::string($data['message'] ?? null, false);
        $this->docsUrl = \Inttegro\ValueHydrator::string($data['docs_url'] ?? null, false);
        $this->source = \Inttegro\ValueHydrator::string($data['source'] ?? null, false);
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
        $this->code = \Inttegro\ValueHydrator::string($data['code'] ?? null, false);
    }

    /**
     * Creates an Error from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Error value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
