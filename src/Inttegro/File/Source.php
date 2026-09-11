<?php

namespace Inttegro\File;


/**
 * Source details associated with file.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Source extends \Inttegro\DomainValue
{
    /**
     * Discriminator identifying the value's API variant.
     *
     * Optional response field. PHP type: `string|null`; wire field: `type` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $type;

    /**
     * Service value for this source.
     *
     * Optional response field. PHP type: `string|null`; wire field: `service` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $service;

    /**
     * Identifier of the related upload request.
     *
     * Optional response field. PHP type: `string|null`; wire field: `upload_request_id` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $uploadRequestId;

    /**
     * Hydrates a Source from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, true);
        $this->service = \Inttegro\ValueHydrator::string($data['service'] ?? null, true);
        $this->uploadRequestId = \Inttegro\ValueHydrator::string($data['upload_request_id'] ?? null, true);
    }

    /**
     * Creates a Source from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Source value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
