<?php

namespace Inttegro\FinancialAccount;

use DateTimeImmutable;

/**
 * A verified destination or source account used to push or pull funds.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class FinancialAccount extends \Inttegro\DomainValue
{
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
     * ISO 4217 currency for the amount.
     *
     * Required response field. PHP type: `string`; wire field: `currency` (`string`).
     *
     * @var string
     */
    public readonly string $currency;

    /**
     * Merchant-defined string values attached to a resource. SDKs expose this as a semantic
     * collection rather than a raw map.
     *
     * Optional response field. PHP type: `array<string, string>|null`; wire field: `custom_data`
     * (`object`).
     *
     * @var array<string, string>|null
     */
    public readonly ?array $customData;

    /**
     * Human-readable description.
     *
     * Optional response field. PHP type: `string|null`; wire field: `description` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $description;

    /**
     * Unique identifier for this financial account.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Institution value for this financial account.
     *
     * Optional response field. PHP type: `\Inttegro\FinancialAccount\FinancialInstitution|null`;
     * wire field: `institution` (`object`).
     *
     * @var \Inttegro\FinancialAccount\FinancialInstitution|null
     */
    public readonly ?\Inttegro\FinancialAccount\FinancialInstitution $institution;

    /**
     * Label value for this financial account.
     *
     * Optional response field. PHP type: `string|null`; wire field: `label` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $label;

    /**
     * Pull Configuration value for this financial account.
     *
     * Optional response field. PHP type: `\Inttegro\FinancialAccount\PullConfiguration|null`; wire
     * field: `pull_configuration` (`object`).
     *
     * @var \Inttegro\FinancialAccount\PullConfiguration|null
     */
    public readonly ?\Inttegro\FinancialAccount\PullConfiguration $pullConfiguration;

    /**
     * Push Configuration value for this financial account.
     *
     * Optional response field. PHP type: `\Inttegro\FinancialAccount\PushConfiguration|null`; wire
     * field: `push_configuration` (`object`).
     *
     * @var \Inttegro\FinancialAccount\PushConfiguration|null
     */
    public readonly ?\Inttegro\FinancialAccount\PushConfiguration $pushConfiguration;

    /**
     * Reference value for this financial account.
     *
     * Optional response field. PHP type: `string|null`; wire field: `reference` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $reference;

    /**
     * Supplied value for this financial account.
     *
     * Optional response field. PHP type: `\Inttegro\Shared\ResourceSupply|null`; wire field:
     * `supplied` (`object`).
     *
     * @var \Inttegro\Shared\ResourceSupply|null
     */
    public readonly ?\Inttegro\Shared\ResourceSupply $supplied;

    /**
     * Discriminator identifying the value's API variant.
     *
     * Required response field. PHP type: `string`; wire field: `type` (`string`).
     * Compare against `Type` cases by using their `->value` strings.
     *
     * @var string
     */
    public readonly string $type;

    /**
     * Verification value for this financial account.
     *
     * Optional response field. PHP type: `array<string, mixed>|null`; wire field: `verification`
     * (`object`).
     *
     * @var array<string, mixed>|null
     */
    public readonly ?array $verification;

    /**
     * Bank Account value for this financial account.
     *
     * Optional response field. PHP type: `\Inttegro\BankAccount\BankAccount|null`; wire field:
     * `bank_account` (`object`).
     *
     * @var \Inttegro\BankAccount\BankAccount|null
     */
    public readonly ?\Inttegro\BankAccount\BankAccount $bankAccount;

    /**
     * Timestamp associated with disconnected.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `disconnected_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $disconnectedAt;

    /**
     * Dosh Account value for this financial account.
     *
     * Optional response field. PHP type: `array<mixed>|null`; wire field: `dosh_account` (`array`).
     *
     * @var array<mixed>|null
     */
    public readonly ?array $doshAccount;

    /**
     * Owner value for this financial account.
     *
     * Optional response field. PHP type: `\Inttegro\BankAccount\Owner|null`; wire field: `owner`
     * (`object`).
     *
     * @var \Inttegro\BankAccount\Owner|null
     */
    public readonly ?\Inttegro\BankAccount\Owner $owner;

    /**
     * Wallet value for this financial account.
     *
     * Optional response field. PHP type: `\Inttegro\Wallet\Wallet|null`; wire field: `wallet`
     * (`object`).
     *
     * @var \Inttegro\Wallet\Wallet|null
     */
    public readonly ?\Inttegro\Wallet\Wallet $wallet;

    /**
     * Hydrates a FinancialAccount from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->archivedAt = \Inttegro\ValueHydrator::dateTime($data['archived_at'] ?? null, true);
        $this->createdAt = \Inttegro\ValueHydrator::dateTime($data['created_at'] ?? null, false);
        $this->currency = \Inttegro\ValueHydrator::string($data['currency'] ?? null, false);
        $this->customData = \Inttegro\ValueHydrator::array($data['custom_data'] ?? null, true);
        $this->description = \Inttegro\ValueHydrator::string($data['description'] ?? null, true);
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->institution = \Inttegro\ValueHydrator::object($data['institution'] ?? null, [\Inttegro\FinancialAccount\FinancialInstitution::class], true);
        $this->label = \Inttegro\ValueHydrator::string($data['label'] ?? null, true);
        $this->pullConfiguration = \Inttegro\ValueHydrator::object($data['pull_configuration'] ?? null, [\Inttegro\FinancialAccount\PullConfiguration::class], true);
        $this->pushConfiguration = \Inttegro\ValueHydrator::object($data['push_configuration'] ?? null, [\Inttegro\FinancialAccount\PushConfiguration::class], true);
        $this->reference = \Inttegro\ValueHydrator::string($data['reference'] ?? null, true);
        $this->supplied = \Inttegro\ValueHydrator::object($data['supplied'] ?? null, [\Inttegro\Shared\ResourceSupply::class], true);
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
        $this->verification = \Inttegro\ValueHydrator::array($data['verification'] ?? null, true);
        $this->bankAccount = \Inttegro\ValueHydrator::object($data['bank_account'] ?? null, [\Inttegro\BankAccount\BankAccount::class], true);
        $this->disconnectedAt = \Inttegro\ValueHydrator::dateTime($data['disconnected_at'] ?? null, true);
        $this->doshAccount = \Inttegro\ValueHydrator::array($data['dosh_account'] ?? null, true);
        $this->owner = \Inttegro\ValueHydrator::object($data['owner'] ?? null, [\Inttegro\BankAccount\Owner::class], true);
        $this->wallet = \Inttegro\ValueHydrator::object($data['wallet'] ?? null, [\Inttegro\Wallet\Wallet::class], true);
    }

    /**
     * Creates a FinancialAccount from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable FinancialAccount value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
