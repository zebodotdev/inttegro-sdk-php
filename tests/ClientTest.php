<?php

use PHPUnit\Framework\TestCase;
use Commerce\Client;
use Commerce\AuthenticationError;

final class ClientTest extends TestCase
{
    private const UUID_V7_REGEX = '/^[0-9a-f]{8}-[0-9a-f]{4}-7[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';

    public function test_paths_cover_spec(): void
    {
        $requests = [];
        $adapter = function ($method, $url, $headers, $payload) use (&$requests) {
            $requests[] = compact('method', 'url', 'headers', 'payload');
            return [
                'status' => 200,
                'body' => json_encode(['ok' => true]),
                'headers' => ['content-type' => 'application/json'],
            ];
        };

        $client = new Client('test-key', 'https://api.zebo.dev', 5, $adapter);

        $client->orders->create(['number' => 'ORDER-1']);
        $client->orders->new(['number' => 'ORDER-2']);
        $client->orders->lookup('or_1');
        $client->orders->pay(['order_id' => 'or_1']);
        $client->orders->confirmPayment(['order_id' => 'or_1', 'token' => '123456']);
        $client->orders->requestConfirmation('or_1');
        $client->orders->finalize('or_1');
        $client->orders->sendInvoice(['order_id' => 'or_1']);
        $client->orders->sendReceipt(['order_id' => 'or_1']);
        $client->orders->complete(['order_id' => 'or_1']);
        $client->orders->cancel('or_1');
        $client->orders->refund('or_1');
        $client->orders->page([]);

        $client->paymentMethods->tokenize(['type' => 'mobile_money']);
        $client->paymentMethods->verify('pm_1');
        $client->paymentMethods->confirmVerification(['payment_method_id' => 'pm_1', 'token' => '123456']);
        $client->paymentMethods->lookup('pm_1');
        $client->paymentMethods->delete('pm_1');
        $client->paymentMethods->settings();

        $client->payouts->setDestinations(['ghs' => 'dest']);
        $client->payouts->settings();
        $client->payouts->disableAutomatic();
        $client->payouts->enableFx();
        $client->payouts->disableFx();
        $client->payouts->page([]);
        $client->payouts->cancel('po_1');

        $client->balanceTransactions->page([]);

        $client->financialAccounts->create(['name' => 'Account']);
        $client->financialAccounts->lookup('fa_1');
        $client->financialAccounts->connect(['name' => 'Account']);
        $client->financialAccounts->archive(['account_id' => 'fa_1']);
        $client->financialAccounts->page([]);
        $client->financialAccounts->verify(['account_id' => 'fa_1']);
        $client->financialAccounts->enablePush('fa_1');
        $client->financialAccounts->disablePush([
            'account_id' => 'fa_1',
            'unset_as_payout_destination' => true,
        ]);
        $client->financialAccounts->enablePull('fa_1');
        $client->financialAccounts->disablePull('fa_1');
        $client->financialAccounts->disconnect([
            'account_id' => 'fa_1',
            'unset_as_payout_destination' => true,
        ]);

        $client->customers->create(['name' => 'Jane Doe']);
        $client->customers->lookup('cu_1');
        $client->customers->page(['page_number' => 1]);

        $client->products->create(['type' => 'physical', 'name' => 'Product']);
        $client->products->addPrice([
            'product_id' => 'prod_1',
            'amount' => ['currency' => 'ghs', 'value' => 5000],
            'set_as_default' => true,
        ]);
        $client->products->setDefaultUnitPrice(['product_id' => 'prod_1', 'price_id' => 'pr_1']);
        $client->products->lookup('prod_1');
        $client->products->update(['product_id' => 'prod_1', 'name' => 'Updated']);
        $client->products->publish('prod_1');
        $client->products->unpublish('prod_1');
        $client->products->archive('prod_1');
        $client->products->page(['page_number' => 1]);

        $client->chimes->send(['message' => 'hi']);
        $client->chimes->lookup('ch_1');
        $client->chimes->schedule([
            'recipients' => ['+233544998605'],
            'full_message' => 'later',
            'send_after' => '2026-01-18T10:00:00Z',
        ]);
        $client->chimes->broadcast([
            'recipients' => ['+233544998605'],
            'message_template' => 'hello',
            'service_name' => 'marketing',
        ]);

        $client->schedules->lookup('sch_1');
        $client->schedules->cancel('sch_1');
        $client->broadcasts->lookup('brc_1');
        $client->broadcasts->cancel('brc_1');

        $client->otp->initiate([
            'recipient' => '+233',
            'sender' => 'Acme',
            'service_name' => 'Acme Bank',
            'idempotency_key' => 'otp_login_1700000000',
            'purpose' => 'login',
        ]);
        $client->otp->verify(['transaction_id' => 'txn_1', 'recipient' => '+233', 'token' => '123456']);
        $client->otp->lookup(['transaction_id' => 'txn_1']);
        $client->otp->cancel(['transaction_id' => 'txn_1', 'reason' => 'test']);

        $client->apps->create(['name' => 'My App']);
        $client->apps->lookup();
        $client->apps->update(['alias' => 'my-app']);

        $client->spec->countries();
        $client->balances->get();

        $paths = array_map(fn($req) => parse_url($req['url'], PHP_URL_PATH), $requests);
        $expected = [
            '/orders/new',
            '/orders/new',
            '/orders/lookup',
            '/orders/pay',
            '/orders/confirm_payment',
            '/orders/request_confirmation',
            '/orders/finalize',
            '/orders/send_invoice',
            '/orders/send_receipt',
            '/orders/complete',
            '/orders/cancel',
            '/orders/refund',
            '/orders/page',
            '/payment_methods/tokenize',
            '/payment_methods/verify',
            '/payment_methods/confirm_verification',
            '/payment_methods/lookup',
            '/payment_methods/delete',
            '/payment_methods/settings',
            '/payouts/set_destinations',
            '/payouts/settings',
            '/payouts/disable',
            '/payouts/enable_fx',
            '/payouts/disable_fx',
            '/payouts/page',
            '/payouts/cancel',
            '/balance_transactions/page',
            '/financial_accounts/create',
            '/financial_accounts/lookup',
            '/financial_accounts/connect',
            '/financial_accounts/archive',
            '/financial_accounts/page',
            '/financial_accounts/verify',
            '/financial_accounts/enable_push',
            '/financial_accounts/disable_push',
            '/financial_accounts/enable_pull',
            '/financial_accounts/disable_pull',
            '/financial_accounts/disconnect',
            '/customers/create',
            '/customers/lookup',
            '/customers/page',
            '/products/create',
            '/products/add_price',
            '/products/set_default_unit_price',
            '/products/lookup',
            '/products/update',
            '/products/publish',
            '/products/unpublish',
            '/products/archive',
            '/products/page',
            '/chimes/send',
            '/chimes/lookup',
            '/chimes/schedule',
            '/chimes/broadcast',
            '/schedules/lookup',
            '/schedules/cancel',
            '/broadcasts/lookup',
            '/broadcasts/cancel',
            '/otp/initiate',
            '/otp/verify',
            '/otp/lookup',
            '/otp/cancel',
            '/apps/create',
            '/apps/lookup',
            '/apps/update',
            '/spec/countries',
            '/balances',
        ];

        $this->assertSame($expected, $paths);
    }

    public function test_authentication_error_is_raised(): void
    {
        $errorAdapter = function () {
            return [
                'status' => 401,
                'body' => json_encode([
                    'type' => 'authentication_error',
                    'code' => 'invalid_api_key',
                    'url' => 'https://studio.inttegro.com/e/invalid_api_key',
                    'message' => 'invalid key',
                    'detail' => 'API key is missing or invalid.',
                    'fix_code' => 'check_api_key',
                    'cause' => 'authentication_failure',
                ]),
                'headers' => ['content-type' => 'application/json'],
            ];
        };

        $client = new Client('bad', 'https://api.zebo.dev', 5, $errorAdapter);

        $this->expectException(AuthenticationError::class);
        $client->orders->lookup('or_1');
    }

    public function test_mutating_posts_generate_request_meta_idempotency_key(): void
    {
        $requests = [];
        $adapter = function ($method, $url, $headers, $payload) use (&$requests) {
            $requests[] = compact('method', 'url', 'headers', 'payload');
            return [
                'status' => 200,
                'body' => json_encode(['ok' => true]),
                'headers' => ['content-type' => 'application/json'],
            ];
        };

        $client = new Client('test-key', 'https://api.zebo.dev', 5, $adapter);
        $client->orders->create(['number' => 'ORDER-1', 'idempotency_key' => 'legacy']);

        $body = json_decode($requests[0]['payload'], true);
        $this->assertArrayNotHasKey('idempotency_key', $body);
        $this->assertMatchesRegularExpression(self::UUID_V7_REGEX, $body['request_meta']['idempotency_key']);
    }

    public function test_read_style_posts_do_not_generate_idempotency_metadata(): void
    {
        $requests = [];
        $adapter = function ($method, $url, $headers, $payload) use (&$requests) {
            $requests[] = compact('method', 'url', 'headers', 'payload');
            return [
                'status' => 200,
                'body' => json_encode(['ok' => true]),
                'headers' => ['content-type' => 'application/json'],
            ];
        };

        $client = new Client('test-key', 'https://api.zebo.dev', 5, $adapter);
        $client->orders->lookup('or_1');

        $body = json_decode($requests[0]['payload'], true);
        $this->assertArrayNotHasKey('request_meta', $body);
        $this->assertArrayNotHasKey('idempotency_key', $body);
    }

    public function test_message_templates_create_uses_request_meta_idempotency_by_default(): void
    {
        $requests = [];
        $adapter = function ($method, $url, $headers, $payload) use (&$requests) {
            $requests[] = compact('method', 'url', 'headers', 'payload');
            return [
                'status' => 200,
                'body' => json_encode(['ok' => true]),
                'headers' => ['content-type' => 'application/json'],
            ];
        };

        $client = new Client('test-key', 'https://api.zebo.dev', 5, $adapter);
        $client->messageTemplates->create([
            'name' => 'welcome_sms',
            'channel' => 'sms',
            'purpose' => 'marketing',
            'sms' => ['message_template' => 'Welcome {{name}}'],
        ]);

        $body = json_decode($requests[0]['payload'], true);
        $headers = implode("\n", $requests[0]['headers']);
        $this->assertStringNotContainsString('Idempotency-Key:', $headers);
        $this->assertMatchesRegularExpression(self::UUID_V7_REGEX, $body['request_meta']['idempotency_key']);
    }
}
