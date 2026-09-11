<?php

namespace Inttegro\Product;


/**
 * Media details associated with product.
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
     * Hero Image value for this media.
     *
     * Optional response field. PHP type: `string|null`; wire field: `hero_image` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $heroImage;

    /**
     * Thumbnail value for this media.
     *
     * Optional response field. PHP type: `string|null`; wire field: `thumbnail` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $thumbnail;

    /**
     * Web Page URL value for this media.
     *
     * Optional response field. PHP type: `string|null`; wire field: `web_page_url` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $webPageUrl;

    /**
     * Brand Logo value for this media.
     *
     * Optional response field. PHP type: `string|null`; wire field: `brand_logo` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $brandLogo;

    /**
     * Infographic value for this media.
     *
     * Optional response field. PHP type: `string|null`; wire field: `infographic` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $infographic;

    /**
     * Promo Video value for this media.
     *
     * Optional response field. PHP type: `string|null`; wire field: `promo_video` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $promoVideo;

    /**
     * Demo Video value for this media.
     *
     * Optional response field. PHP type: `string|null`; wire field: `demo_video` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $demoVideo;

    /**
     * Gallery value for this media.
     *
     * Optional response field. PHP type: `list<string>|null`; wire field: `gallery`
     * (`array<string>`).
     *
     * @var list<string>|null
     */
    public readonly ?array $gallery;

    /**
     * Downloads value for this media.
     *
     * Optional response field. PHP type: `list<string>|null`; wire field: `downloads`
     * (`array<string>`).
     *
     * @var list<string>|null
     */
    public readonly ?array $downloads;

    /**
     * Hydrates a Media from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->heroImage = \Inttegro\ValueHydrator::string($data['hero_image'] ?? null, true);
        $this->thumbnail = \Inttegro\ValueHydrator::string($data['thumbnail'] ?? null, true);
        $this->webPageUrl = \Inttegro\ValueHydrator::string($data['web_page_url'] ?? null, true);
        $this->brandLogo = \Inttegro\ValueHydrator::string($data['brand_logo'] ?? null, true);
        $this->infographic = \Inttegro\ValueHydrator::string($data['infographic'] ?? null, true);
        $this->promoVideo = \Inttegro\ValueHydrator::string($data['promo_video'] ?? null, true);
        $this->demoVideo = \Inttegro\ValueHydrator::string($data['demo_video'] ?? null, true);
        $this->gallery = \Inttegro\ValueHydrator::array($data['gallery'] ?? null, true);
        $this->downloads = \Inttegro\ValueHydrator::array($data['downloads'] ?? null, true);
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
