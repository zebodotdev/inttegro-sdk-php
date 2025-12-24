<?php

require __DIR__ . '/../src/autoload.php';
require __DIR__ . '/TestCase.php';

use Commerce\Client;
use Commerce\AuthenticationError;

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
$client->orders->lookup('ord_1');
$client->orders->pay(['order_id' => 'ord_1']);
$client->orders->confirmPayment(['order_id' => 'ord_1', 'token' => '123456']);
$client->orders->requestConfirmation('ord_1');
$client->orders->finalize('ord_1');
$client->orders->complete(['order_id' => 'ord_1']);
$client->orders->cancel('ord_1');
$client->orders->refund('ord_1');
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

$client->balanceTransactions->page([]);

$client->financialAccounts->create(['name' => 'Account']);
$client->financialAccounts->lookup('fa_1');
$client->financialAccounts->connect(['name' => 'Account']);
$client->financialAccounts->archive(['account_id' => 'fa_1']);
$client->financialAccounts->page([]);
$client->financialAccounts->verify(['account_id' => 'fa_1']);

$client->chimes->send(['message' => 'hi']);
$client->chimes->lookup('ch_1');
$client->chimes->schedule(['message' => 'later']);

$client->otp->initiate(['recipient' => '+233', 'purpose' => 'login']);
$client->otp->verify(['transaction_id' => 'txn_1', 'token' => '123456']);
$client->otp->lookup(['transaction_id' => 'txn_1']);
$client->otp->cancel(['transaction_id' => 'txn_1', 'reason' => 'test']);

$client->platform->createApp(['name' => 'My App']);
$client->platform->generateKey(['app_id' => 'app_1']);
$client->platform->newSession(['app_id' => 'app_1']);

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
    '/balance_transactions/page',
    '/financial_accounts/create',
    '/financial_accounts/lookup',
    '/financial_accounts/connect',
    '/financial_accounts/archive',
    '/financial_accounts/page',
    '/financial_accounts/verify',
    '/chimes/send',
    '/chimes/lookup',
    '/chimes/schedule',
    '/otp/initialize',
    '/otp/verify',
    '/otp/lookup',
    '/otp/cancel',
    '/apps/create',
    '/keys/generate',
    '/sessions/new',
    '/spec/countries',
    '/balances',
];

assertEquals($expected, $paths);

$errorAdapter = function () {
    return [
        'status' => 401,
        'body' => json_encode([
            'type' => 'authentication_error',
            'code' => 'invalid_api_key',
            'url' => 'https://commerce.zebo.dev/e/invalid_api_key',
            'message' => 'invalid key',
            'detail' => 'API key is missing or invalid.',
            'fix_code' => 'check_api_key',
            'cause' => 'authentication_failure',
        ]),
        'headers' => ['content-type' => 'application/json'],
    ];
};

$errorClient = new Client('bad-key', 'https://api.zebo.dev', 5, $errorAdapter);

$caught = false;
try {
    $errorClient->orders->lookup('ord_123');
} catch (AuthenticationError $e) {
    $caught = true;
    assertEquals(401, $e->status);
}

assertTrue($caught, 'AuthenticationError was not raised');

$wrapper = $client->orders->create(['order' => ['id' => 'ord_123']]);
assertEquals('ord_123', $wrapper->order->id);
assertEquals('ord_123', $wrapper['order']->id);

echo "All tests passed\n";
