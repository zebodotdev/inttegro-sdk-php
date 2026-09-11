<?php

namespace Inttegro\File;


/**
 * Purpose-authorized public delivery metadata for browser-rendered assets. Callers should store
 * file IDs as canonical references and treat these URLs as render URLs.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class DeliveryDetails extends \Inttegro\DomainValue
{
    /**
     * Unsigned CDN URL for public-safe assets such as product images.
     *
     * Optional response field. PHP type: `string|null`; wire field: `public_url` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $publicUrl;

    /**
     * Cache Control value for this delivery details.
     *
     * Optional response field. PHP type: `string|null`; wire field: `cache_control` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $cacheControl;

    /**
     * Content Type value for this delivery details.
     *
     * Optional response field. PHP type: `string|null`; wire field: `content_type` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $contentType;

    /**
     * Hydrates a DeliveryDetails from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->publicUrl = \Inttegro\ValueHydrator::string($data['public_url'] ?? null, true);
        $this->cacheControl = \Inttegro\ValueHydrator::string($data['cache_control'] ?? null, true);
        $this->contentType = \Inttegro\ValueHydrator::string($data['content_type'] ?? null, true);
    }

    /**
     * Creates a DeliveryDetails from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable DeliveryDetails value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
