<?php

namespace Inttegro\PurchaseIntent;

use DateTimeImmutable;

/**
 * A shareable purchase intent that captures product, price, quantity, variants, usage, and buyer
 * activity.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class PurchaseIntent extends \Inttegro\DomainValue
{
    /**
     * Recent authenticated-owner activity for the purchase intent.
     *
     * Optional response field. PHP type: `\Inttegro\PurchaseIntent\ActivityLog|null`; wire field:
     * `activity` (`object`).
     *
     * @var \Inttegro\PurchaseIntent\ActivityLog|null
     */
    public readonly ?\Inttegro\PurchaseIntent\ActivityLog $activity;

    /**
     * Whether the intent was configured with a variant set.
     *
     * Required response field. PHP type: `bool`; wire field: `allow_variants` (`boolean`).
     *
     * @var bool
     */
    public readonly bool $allowVariants;

    /**
     * Creation timestamp.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `created_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $createdAt;

    /**
     * Timestamp at or after which the Buy link is expired.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `expires_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $expiresAt;

    /**
     * Unique purchase intent identifier with sale_ prefix. Append it to
     * https://pages.inttegro.com/buy/ to build the hosted Buy link.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * When the Buy link was explicitly canceled.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `inactive_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $inactiveAt;

    /**
     * Merchant identity captured for the hosted checkout. Individual fields are omitted when
     * unavailable.
     *
     * Optional response field. PHP type: `\Inttegro\PurchaseIntent\Merchant|null`; wire field:
     * `merchant` (`object`).
     *
     * @var \Inttegro\PurchaseIntent\Merchant|null
     */
    public readonly ?\Inttegro\PurchaseIntent\Merchant $merchant;

    /**
     * Price value for this purchase intent.
     *
     * Optional response field. PHP type: `\Inttegro\PurchaseIntent\Price|null`; wire field: `price`
     * (`object`).
     *
     * @var \Inttegro\PurchaseIntent\Price|null
     */
    public readonly ?\Inttegro\PurchaseIntent\Price $price;

    /**
     * Product value for this purchase intent.
     *
     * Optional response field. PHP type: `\Inttegro\PurchaseIntent\Product|null`; wire field:
     * `product` (`object`).
     *
     * @var \Inttegro\PurchaseIntent\Product|null
     */
    public readonly ?\Inttegro\PurchaseIntent\Product $product;

    /**
     * Quantity bounds enforced by the hosted checkout. max is omitted when the offer has no upper
     * bound.
     *
     * Required response field. PHP type: `\Inttegro\PurchaseIntent\Quantity`; wire field:
     * `quantity` (`object`).
     *
     * @var \Inttegro\PurchaseIntent\Quantity
     */
    public readonly \Inttegro\PurchaseIntent\Quantity $quantity;

    /**
     * Effective lifecycle state derived from expiry, cancellation, and single-use order creation.
     *
     * Required response field. PHP type: `\Inttegro\PurchaseIntent\Status`; wire field: `status`
     * (`string`).
     * Compare against `Status` cases by using their `->value` strings.
     *
     * @var \Inttegro\PurchaseIntent\Status
     */
    public readonly \Inttegro\PurchaseIntent\Status $status;

    /**
     * Last mutation timestamp.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `updated_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $updatedAt;

    /**
     * Exactly one of multi_use or single_use is returned as true. Order is present after a
     * single-use intent is consumed.
     *
     * Required response field. PHP type: `\Inttegro\PurchaseIntent\Usage`; wire field: `usage`
     * (`object`).
     *
     * @var \Inttegro\PurchaseIntent\Usage
     */
    public readonly \Inttegro\PurchaseIntent\Usage $usage;

    /**
     * Variant Set value for this purchase intent.
     *
     * Optional response field. PHP type: `\Inttegro\PurchaseIntent\VariantSet|null`; wire field:
     * `variant_set` (`object`).
     *
     * @var \Inttegro\PurchaseIntent\VariantSet|null
     */
    public readonly ?\Inttegro\PurchaseIntent\VariantSet $variantSet;

    /**
     * Hydrates a PurchaseIntent from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->activity = \Inttegro\ValueHydrator::object($data['activity'] ?? null, [\Inttegro\PurchaseIntent\ActivityLog::class], true);
        $this->allowVariants = \Inttegro\ValueHydrator::bool($data['allow_variants'] ?? null, false);
        $this->createdAt = \Inttegro\ValueHydrator::dateTime($data['created_at'] ?? null, false);
        $this->expiresAt = \Inttegro\ValueHydrator::dateTime($data['expires_at'] ?? null, true);
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->inactiveAt = \Inttegro\ValueHydrator::dateTime($data['inactive_at'] ?? null, true);
        $this->merchant = \Inttegro\ValueHydrator::object($data['merchant'] ?? null, [\Inttegro\PurchaseIntent\Merchant::class], true);
        $this->price = \Inttegro\ValueHydrator::object($data['price'] ?? null, [\Inttegro\PurchaseIntent\Price::class], true);
        $this->product = \Inttegro\ValueHydrator::object($data['product'] ?? null, [\Inttegro\PurchaseIntent\Product::class], true);
        $this->quantity = \Inttegro\ValueHydrator::object($data['quantity'] ?? null, [\Inttegro\PurchaseIntent\Quantity::class], false);
        $this->status = \Inttegro\PurchaseIntent\Status::from(\Inttegro\ValueHydrator::string($data['status'] ?? null, false));
        $this->updatedAt = \Inttegro\ValueHydrator::dateTime($data['updated_at'] ?? null, true);
        $this->usage = \Inttegro\ValueHydrator::object($data['usage'] ?? null, [\Inttegro\PurchaseIntent\Usage::class], false);
        $this->variantSet = \Inttegro\ValueHydrator::object($data['variant_set'] ?? null, [\Inttegro\PurchaseIntent\VariantSet::class], true);
    }

    /**
     * Creates a PurchaseIntent from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable PurchaseIntent value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }

    /**
     * Reports whether the purchase intent is active.
     */
    public function isActive(): bool
    {
        return $this->status === \Inttegro\PurchaseIntent\Status::Active;
    }

    /**
     * Reports whether the purchase intent can be consumed only once.
     */
    public function isSingleUse(): bool
    {
        return $this->usage->singleUse === true;
    }

    /**
     * Returns the consuming order ID for a used single-use purchase intent, or null when none exists.
     */
    public function usedOrderId(): ?string
    {
        $id = $this->isSingleUse() ? $this->usage->order?->id : null;
        return $id === null || $id === '' ? null : $id;
    }
}
