<?php

use PHPUnit\Framework\TestCase;

final class PackageLayoutTest extends TestCase
{
    public function test_resource_definitions_live_in_singular_namespaces(): void
    {
        $resources = [
            \Inttegro\App\App::class,
            \Inttegro\Balance\Balance::class,
            \Inttegro\BalanceTransaction\BalanceTransaction::class,
            \Inttegro\BankAccount\BankAccount::class,
            \Inttegro\Broadcast\Broadcast::class,
            \Inttegro\Chime\Chime::class,
            \Inttegro\Customer\Customer::class,
            \Inttegro\File\File::class,
            \Inttegro\FileLink\FileLink::class,
            \Inttegro\FinancialAccount\FinancialAccount::class,
            \Inttegro\MessageTemplate\MessageTemplate::class,
            \Inttegro\Order\Order::class,
            \Inttegro\Payment\Payment::class,
            \Inttegro\PaymentMethod\PaymentMethod::class,
            \Inttegro\Payout\Payout::class,
            \Inttegro\Price\Price::class,
            \Inttegro\Product\Product::class,
            \Inttegro\PurchaseIntent\PurchaseIntent::class,
            \Inttegro\Refund\Refund::class,
            \Inttegro\Schedule\Schedule::class,
            \Inttegro\SecretKey\SecretKey::class,
            \Inttegro\UploadRequest\UploadRequest::class,
            \Inttegro\Wallet\Wallet::class,
        ];

        foreach ($resources as $resource) {
            $this->assertTrue(class_exists($resource), $resource);
        }

        $this->assertTrue(enum_exists(\Inttegro\Product\Type::class));
        $this->assertTrue(enum_exists(\Inttegro\Refund\Status::class));
    }

    public function test_removed_flat_types_and_alias_namespaces_do_not_resolve(): void
    {
        $this->assertFalse(class_exists('Inttegro\\Payment'));
        $this->assertFalse(class_exists('Inttegro\\Product'));
        $this->assertFalse(class_exists('Inttegro\\CatalogPrice'));
        $this->assertFalse(class_exists('Inttegro\\Wallets\\Wallet'));
        $this->assertFalse(class_exists('Inttegro\\BankAccounts\\BankAccount'));
        $this->assertFalse(enum_exists('Inttegro\\ProductType'));
        $this->assertFalse(enum_exists('Inttegro\\RefundStatus'));
    }

    public function test_monolithic_definition_files_are_gone(): void
    {
        $source = dirname(__DIR__) . '/src/Inttegro';

        $this->assertFileDoesNotExist($source . '/Domain.php');
        $this->assertFileDoesNotExist($source . '/Enums.php');
        $this->assertFileDoesNotExist($source . '/Wallets.php');
        $this->assertFileDoesNotExist($source . '/BankAccounts.php');
    }
}
