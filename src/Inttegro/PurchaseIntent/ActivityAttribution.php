<?php

namespace Inttegro\PurchaseIntent;


/**
 * Activity Attribution details associated with purchase intent.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class ActivityAttribution extends \Inttegro\DomainValue
{
    /**
     * Campaign value for this activity attribution.
     *
     * Optional response field. PHP type: `string|null`; wire field: `campaign` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $campaign;

    /**
     * Channel value for this activity attribution.
     *
     * Optional response field. PHP type: `string|null`; wire field: `channel` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $channel;

    /**
     * Content value for this activity attribution.
     *
     * Optional response field. PHP type: `string|null`; wire field: `content` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $content;

    /**
     * Landing URL value for this activity attribution.
     *
     * Optional response field. PHP type: `string|null`; wire field: `landing_url` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $landingUrl;

    /**
     * Medium value for this activity attribution.
     *
     * Optional response field. PHP type: `string|null`; wire field: `medium` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $medium;

    /**
     * Referrer value for this activity attribution.
     *
     * Optional response field. PHP type: `string|null`; wire field: `referrer` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $referrer;

    /**
     * Referrer Host value for this activity attribution.
     *
     * Optional response field. PHP type: `string|null`; wire field: `referrer_host` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $referrerHost;

    /**
     * Source value for this activity attribution.
     *
     * Optional response field. PHP type: `string|null`; wire field: `source` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $source;

    /**
     * Term value for this activity attribution.
     *
     * Optional response field. PHP type: `string|null`; wire field: `term` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $term;

    /**
     * Hydrates an ActivityAttribution from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->campaign = \Inttegro\ValueHydrator::string($data['campaign'] ?? null, true);
        $this->channel = \Inttegro\ValueHydrator::string($data['channel'] ?? null, true);
        $this->content = \Inttegro\ValueHydrator::string($data['content'] ?? null, true);
        $this->landingUrl = \Inttegro\ValueHydrator::string($data['landing_url'] ?? null, true);
        $this->medium = \Inttegro\ValueHydrator::string($data['medium'] ?? null, true);
        $this->referrer = \Inttegro\ValueHydrator::string($data['referrer'] ?? null, true);
        $this->referrerHost = \Inttegro\ValueHydrator::string($data['referrer_host'] ?? null, true);
        $this->source = \Inttegro\ValueHydrator::string($data['source'] ?? null, true);
        $this->term = \Inttegro\ValueHydrator::string($data['term'] ?? null, true);
    }

    /**
     * Creates an ActivityAttribution from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable ActivityAttribution value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
