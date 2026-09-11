<?php

namespace Inttegro\PurchaseIntent;


/**
 * Activity Visitor details associated with purchase intent.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class ActivityVisitor extends \Inttegro\DomainValue
{
    /**
     * Browser value for this activity visitor.
     *
     * Optional response field. PHP type: `string|null`; wire field: `browser` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $browser;

    /**
     * City value for this activity visitor.
     *
     * Optional response field. PHP type: `string|null`; wire field: `city` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $city;

    /**
     * Country value for this activity visitor.
     *
     * Optional response field. PHP type: `string|null`; wire field: `country` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $country;

    /**
     * Device value for this activity visitor.
     *
     * Optional response field. PHP type: `string|null`; wire field: `device` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $device;

    /**
     * Request IP address when retained for the activity type.
     *
     * Optional response field. PHP type: `string|null`; wire field: `ip_address` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $ipAddress;

    /**
     * Os value for this activity visitor.
     *
     * Optional response field. PHP type: `string|null`; wire field: `os` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $os;

    /**
     * Region value for this activity visitor.
     *
     * Optional response field. PHP type: `string|null`; wire field: `region` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $region;

    /**
     * Identifier of the related session.
     *
     * Optional response field. PHP type: `string|null`; wire field: `session_id` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $sessionId;

    /**
     * Timezone value for this activity visitor.
     *
     * Optional response field. PHP type: `string|null`; wire field: `timezone` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $timezone;

    /**
     * User Agent value for this activity visitor.
     *
     * Optional response field. PHP type: `string|null`; wire field: `user_agent` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $userAgent;

    /**
     * Identifier of the related visitor.
     *
     * Optional response field. PHP type: `string|null`; wire field: `visitor_id` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $visitorId;

    /**
     * Hydrates an ActivityVisitor from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->browser = \Inttegro\ValueHydrator::string($data['browser'] ?? null, true);
        $this->city = \Inttegro\ValueHydrator::string($data['city'] ?? null, true);
        $this->country = \Inttegro\ValueHydrator::string($data['country'] ?? null, true);
        $this->device = \Inttegro\ValueHydrator::string($data['device'] ?? null, true);
        $this->ipAddress = \Inttegro\ValueHydrator::string($data['ip_address'] ?? null, true);
        $this->os = \Inttegro\ValueHydrator::string($data['os'] ?? null, true);
        $this->region = \Inttegro\ValueHydrator::string($data['region'] ?? null, true);
        $this->sessionId = \Inttegro\ValueHydrator::string($data['session_id'] ?? null, true);
        $this->timezone = \Inttegro\ValueHydrator::string($data['timezone'] ?? null, true);
        $this->userAgent = \Inttegro\ValueHydrator::string($data['user_agent'] ?? null, true);
        $this->visitorId = \Inttegro\ValueHydrator::string($data['visitor_id'] ?? null, true);
    }

    /**
     * Creates an ActivityVisitor from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable ActivityVisitor value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
