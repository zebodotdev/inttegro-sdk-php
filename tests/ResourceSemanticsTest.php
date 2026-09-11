<?php

use Inttegro\Order\Order;
use Inttegro\Payment\Payment;
use Inttegro\PaymentMethod\PaymentMethod;
use Inttegro\Product\Product;
use Inttegro\PurchaseIntent\PurchaseIntent;
use PHPUnit\Framework\TestCase;

final class ResourceSemanticsTest extends TestCase
{
    public function testPaymentAndOrderQuestions(): void
    {
        $payment = Payment::fromArray([
            'amount' => ['currency' => 'ghs', 'value' => 1000],
            'id' => 'py_123',
            'initiated_at' => '2026-09-09T12:00:00Z',
            'next_action' => ['type' => 'redirect'],
            'statement_descriptor' => 'INTTEGRO',
            'status' => 'requires_action',
        ]);
        $order = Order::fromArray([
            'customer' => ['guest' => false, 'id' => 'cu_123', 'name' => 'Ama'],
            'id' => 'or_123',
            'initiated_at' => '2026-09-09T12:00:00Z',
            'payment' => $payment->toArray(),
            'status' => 'requires_payment',
        ]);

        self::assertTrue($payment->requiresAction());
        self::assertFalse($payment->isTerminal());
        self::assertSame('redirect', $payment->requiredAction()?->type);
        self::assertTrue($order->requiresPayment());
        self::assertSame('redirect', $order->requiredPaymentAction()?->type);
    }

    public function testCatalogAndPaymentMethodQuestions(): void
    {
        $intent = PurchaseIntent::fromArray([
            'allow_variants' => false,
            'created_at' => '2026-09-09T12:00:00Z',
            'id' => 'sale_123',
            'quantity' => ['min' => 1],
            'status' => 'used',
            'usage' => [
                'order' => ['created_at' => '2026-09-09T12:01:00Z', 'id' => 'or_123'],
                'single_use' => true,
            ],
        ]);
        $product = Product::fromArray([
            'active' => true,
            'created_at' => '2026-09-09T12:00:00Z',
            'id' => 'prod_123',
            'name' => 'Tea guide',
            'published_at' => '2026-09-09T12:00:00Z',
            'type' => 'digital',
        ]);
        $method = PaymentMethod::fromArray([
            'active' => true,
            'created_at' => '2026-09-09T12:00:00Z',
            'customer_id' => 'cu_123',
            'id' => 'pm_123',
            'type' => 'mobile_money',
            'verified_at' => '2026-09-09T12:00:00Z',
        ]);

        self::assertTrue($intent->isSingleUse());
        self::assertSame('or_123', $intent->usedOrderId());
        self::assertTrue($product->isPublished());
        self::assertTrue($product->wasEverPublished());
        self::assertTrue($method->isVerified());
        self::assertTrue($method->isReusable());
    }
}
