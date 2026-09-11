<?php

namespace Inttegro\BalanceTransaction;


/**
 * A page of balance transaction values together with pagination metadata.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Page extends \Inttegro\DomainValue
{
    /**
     * Page or business reference number, as defined by the containing value.
     *
     * Required response field. PHP type: `int`; wire field: `number` (`integer`).
     *
     * @var int
     */
    public readonly int $number;

    /**
     * Size value for this page.
     *
     * Required response field. PHP type: `int`; wire field: `size` (`integer`).
     *
     * @var int
     */
    public readonly int $size;

    /**
     * Newest transactions first. Omitted when the page is empty.
     *
     * Optional response field. PHP type:
     * `list<\Inttegro\BalanceTransaction\BalanceTransaction>|null`; wire field: `transactions`
     * (`array<object>`).
     * When the field is absent, the SDK exposes an empty collection.
     *
     * @var list<\Inttegro\BalanceTransaction\BalanceTransaction>|null
     */
    public readonly ?array $transactions;

    /**
     * Hydrates a Page from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->number = \Inttegro\ValueHydrator::int($data['number'] ?? null, false);
        $this->size = \Inttegro\ValueHydrator::int($data['size'] ?? null, false);
        $this->transactions = \Inttegro\ValueHydrator::objects($data['transactions'] ?? null, [\Inttegro\BalanceTransaction\BalanceTransaction::class]);
    }

    /**
     * Creates a Page from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Page value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
