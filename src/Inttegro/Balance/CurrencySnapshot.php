<?php

namespace Inttegro\Balance;

use DateTimeImmutable;

/**
 * Currency Snapshot details associated with balance.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class CurrencySnapshot extends \Inttegro\DomainValue
{
    /**
     * Available value for this currency snapshot.
     *
     * Required response field. PHP type: `\Inttegro\Balance\Value`; wire field: `available`
     * (`object`).
     *
     * @var \Inttegro\Balance\Value
     */
    public readonly \Inttegro\Balance\Value $available;

    /**
     * The snapshot includes transactions created before this timestamp.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field:
     * `includes_transactions_before` (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $includesTransactionsBefore;

    /**
     * Pending value for this currency snapshot.
     *
     * Required response field. PHP type: `\Inttegro\Balance\Value`; wire field: `pending`
     * (`object`).
     *
     * @var \Inttegro\Balance\Value
     */
    public readonly \Inttegro\Balance\Value $pending;

    /**
     * Funds assigned to refund activity at the snapshot cutoff.
     *
     * Required response field. PHP type: `\Inttegro\Balance\CurrencySnapshotRefund`; wire field:
     * `refund` (`object`).
     *
     * @var \Inttegro\Balance\CurrencySnapshotRefund
     */
    public readonly \Inttegro\Balance\CurrencySnapshotRefund $refund;

    /**
     * Funds held back from payout at the snapshot cutoff.
     *
     * Required response field. PHP type: `\Inttegro\Balance\CurrencySnapshotReserved`; wire field:
     * `reserved` (`object`).
     *
     * @var \Inttegro\Balance\CurrencySnapshotReserved
     */
    public readonly \Inttegro\Balance\CurrencySnapshotReserved $reserved;

    /**
     * Hydrates a CurrencySnapshot from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->available = \Inttegro\ValueHydrator::object($data['available'] ?? null, [\Inttegro\Balance\Value::class], false);
        $this->includesTransactionsBefore = \Inttegro\ValueHydrator::dateTime($data['includes_transactions_before'] ?? null, false);
        $this->pending = \Inttegro\ValueHydrator::object($data['pending'] ?? null, [\Inttegro\Balance\Value::class], false);
        $this->refund = \Inttegro\ValueHydrator::object($data['refund'] ?? null, [\Inttegro\Balance\CurrencySnapshotRefund::class], false);
        $this->reserved = \Inttegro\ValueHydrator::object($data['reserved'] ?? null, [\Inttegro\Balance\CurrencySnapshotReserved::class], false);
    }

    /**
     * Creates a CurrencySnapshot from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable CurrencySnapshot value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
