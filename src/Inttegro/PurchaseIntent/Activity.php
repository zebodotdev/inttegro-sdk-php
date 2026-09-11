<?php

namespace Inttegro\PurchaseIntent;

use DateTimeImmutable;
use Inttegro\Money\Amount;

/**
 * Activity details associated with purchase intent.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Activity extends \Inttegro\DomainValue
{
    /**
     * Monetary amount in integer minor units and its currency.
     *
     * Optional response field. PHP type: `Amount|null`; wire field: `amount` (`object`).
     *
     * @var Amount|null
     */
    public readonly ?Amount $amount;

    /**
     * Attribution value for this activity.
     *
     * Optional response field. PHP type: `\Inttegro\PurchaseIntent\ActivityAttribution|null`; wire
     * field: `attribution` (`object`).
     *
     * @var \Inttegro\PurchaseIntent\ActivityAttribution|null
     */
    public readonly ?\Inttegro\PurchaseIntent\ActivityAttribution $attribution;

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
     * Error Code value for this activity.
     *
     * Optional response field. PHP type: `string|null`; wire field: `error_code` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $errorCode;

    /**
     * Activity event ID with saleevt_ prefix.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Identifier of the related order.
     *
     * Optional response field. PHP type: `string|null`; wire field: `order_id` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $orderId;

    /**
     * Identifier of the related payment.
     *
     * Optional response field. PHP type: `string|null`; wire field: `payment_id` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $paymentId;

    /**
     * Identifier of the related product.
     *
     * Optional response field. PHP type: `string|null`; wire field: `product_id` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $productId;

    /**
     * Purchase intent ID with sale_ prefix.
     *
     * Required response field. PHP type: `string`; wire field: `purchase_intent_id` (`string`).
     *
     * @var string
     */
    public readonly string $purchaseIntentId;

    /**
     * Quantity value for this activity.
     *
     * Optional response field. PHP type: `int|null`; wire field: `quantity` (`integer`).
     *
     * @var int|null
     */
    public readonly ?int $quantity;

    /**
     * Source value for this activity.
     *
     * Optional response field. PHP type: `string|null`; wire field: `source` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $source;

    /**
     * Discriminator identifying the value's API variant.
     *
     * Required response field. PHP type: `\Inttegro\PurchaseIntent\ActivityType`; wire field:
     * `type` (`string`).
     *
     * @var \Inttegro\PurchaseIntent\ActivityType
     */
    public readonly \Inttegro\PurchaseIntent\ActivityType $type;

    /**
     * Identifier of the related variant product.
     *
     * Optional response field. PHP type: `string|null`; wire field: `variant_product_id`
     * (`string`).
     *
     * @var string|null
     */
    public readonly ?string $variantProductId;

    /**
     * Visitor value for this activity.
     *
     * Optional response field. PHP type: `\Inttegro\PurchaseIntent\ActivityVisitor|null`; wire
     * field: `visitor` (`object`).
     *
     * @var \Inttegro\PurchaseIntent\ActivityVisitor|null
     */
    public readonly ?\Inttegro\PurchaseIntent\ActivityVisitor $visitor;

    /**
     * Hydrates an Activity from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->amount = \Inttegro\ValueHydrator::object($data['amount'] ?? null, [Amount::class], true);
        $this->attribution = \Inttegro\ValueHydrator::object($data['attribution'] ?? null, [\Inttegro\PurchaseIntent\ActivityAttribution::class], true);
        $this->createdAt = \Inttegro\ValueHydrator::dateTime($data['created_at'] ?? null, false);
        $this->errorCode = \Inttegro\ValueHydrator::string($data['error_code'] ?? null, true);
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->orderId = \Inttegro\ValueHydrator::string($data['order_id'] ?? null, true);
        $this->paymentId = \Inttegro\ValueHydrator::string($data['payment_id'] ?? null, true);
        $this->productId = \Inttegro\ValueHydrator::string($data['product_id'] ?? null, true);
        $this->purchaseIntentId = \Inttegro\ValueHydrator::string($data['purchase_intent_id'] ?? null, false);
        $this->quantity = \Inttegro\ValueHydrator::int($data['quantity'] ?? null, true);
        $this->source = \Inttegro\ValueHydrator::string($data['source'] ?? null, true);
        $this->type = \Inttegro\PurchaseIntent\ActivityType::from(\Inttegro\ValueHydrator::string($data['type'] ?? null, false));
        $this->variantProductId = \Inttegro\ValueHydrator::string($data['variant_product_id'] ?? null, true);
        $this->visitor = \Inttegro\ValueHydrator::object($data['visitor'] ?? null, [\Inttegro\PurchaseIntent\ActivityVisitor::class], true);
    }

    /**
     * Creates an Activity from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Activity value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
