<?php

namespace Inttegro\File;


/**
 * Media details associated with file.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Media extends \Inttegro\DomainValue
{
    /**
     * Kind value for this media.
     *
     * Optional response field. PHP type: `string|null`; wire field: `kind` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $kind;

    /**
     * Width value for this media.
     *
     * Optional response field. PHP type: `int|null`; wire field: `width` (`integer`).
     *
     * @var int|null
     */
    public readonly ?int $width;

    /**
     * Height value for this media.
     *
     * Optional response field. PHP type: `int|null`; wire field: `height` (`integer`).
     *
     * @var int|null
     */
    public readonly ?int $height;

    /**
     * Duration Ms value for this media.
     *
     * Optional response field. PHP type: `int|null`; wire field: `duration_ms` (`integer`).
     *
     * @var int|null
     */
    public readonly ?int $durationMs;

    /**
     * Page Count value for this media.
     *
     * Optional response field. PHP type: `int|null`; wire field: `page_count` (`integer`).
     *
     * @var int|null
     */
    public readonly ?int $pageCount;

    /**
     * Frame Count value for this media.
     *
     * Optional response field. PHP type: `int|null`; wire field: `frame_count` (`integer`).
     *
     * @var int|null
     */
    public readonly ?int $frameCount;

    /**
     * Color Space value for this media.
     *
     * Optional response field. PHP type: `string|null`; wire field: `color_space` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $colorSpace;

    /**
     * Has Alpha value for this media.
     *
     * Optional response field. PHP type: `bool|null`; wire field: `has_alpha` (`boolean`).
     *
     * @var bool|null
     */
    public readonly ?bool $hasAlpha;

    /**
     * Codec value for this media.
     *
     * Optional response field. PHP type: `string|null`; wire field: `codec` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $codec;

    /**
     * Aspect Ratio value for this media.
     *
     * Optional response field. PHP type: `string|null`; wire field: `aspect_ratio` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $aspectRatio;

    /**
     * Hydrates a Media from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->kind = \Inttegro\ValueHydrator::string($data['kind'] ?? null, true);
        $this->width = \Inttegro\ValueHydrator::int($data['width'] ?? null, true);
        $this->height = \Inttegro\ValueHydrator::int($data['height'] ?? null, true);
        $this->durationMs = \Inttegro\ValueHydrator::int($data['duration_ms'] ?? null, true);
        $this->pageCount = \Inttegro\ValueHydrator::int($data['page_count'] ?? null, true);
        $this->frameCount = \Inttegro\ValueHydrator::int($data['frame_count'] ?? null, true);
        $this->colorSpace = \Inttegro\ValueHydrator::string($data['color_space'] ?? null, true);
        $this->hasAlpha = \Inttegro\ValueHydrator::bool($data['has_alpha'] ?? null, true);
        $this->codec = \Inttegro\ValueHydrator::string($data['codec'] ?? null, true);
        $this->aspectRatio = \Inttegro\ValueHydrator::string($data['aspect_ratio'] ?? null, true);
    }

    /**
     * Creates a Media from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Media value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
