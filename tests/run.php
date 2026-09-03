<?php

require __DIR__ . '/../src/autoload.php';
require __DIR__ . '/TestCase.php';

use Inttegro\Client;
use Inttegro\AuthenticationError;

function openApiSpecPaths(): array
{
    $specPath = getenv('INTTEGRO_OPENAPI_SPEC') ?: dirname(__DIR__) . '/../../openapi/commerce.yml';
    assertTrue(is_file($specPath), "OpenAPI spec not found at $specPath");

    $contents = file_get_contents($specPath);
    assertTrue(is_string($contents), "Unable to read OpenAPI spec at $specPath");

    preg_match_all('/^    (\/[A-Za-z0-9_\/{}.-]+):\s*$/m', $contents, $matches);
    $paths = array_values(array_unique($matches[1]));
    sort($paths);

    return $paths;
}

function implementedSdkPaths(): array
{
    $resourceFiles = glob(dirname(__DIR__) . '/src/Inttegro/Resources/*.php') ?: [];
    $paths = [];
    foreach ($resourceFiles as $resourceFile) {
        $contents = file_get_contents($resourceFile);
        if (!is_string($contents)) {
            continue;
        }
        preg_match_all(
            '/->(?:postResource|postValue|postMultipartResource|postMultipartValue|postBinaryJson)\(\s*[\'"](\/[a-z0-9_\/-]+)[\'"]/m',
            $contents,
            $matches
        );
        array_push($paths, ...$matches[1]);
    }

    $paths = array_values(array_unique($paths));
    sort($paths);

    return $paths;
}

$missing = array_values(array_diff(
    openApiSpecPaths(),
    ['/file_links/open', '/upload_requests/upload'],
    implementedSdkPaths()
));
assertEquals(
    [],
    $missing,
    "SDK implementation is missing explicit OpenAPI path coverage:\n" . implode("\n", $missing)
);

$requests = [];
$adapter = function ($method, $url, $headers, $payload) use (&$requests) {
    $requests[] = compact('method', 'url', 'headers', 'payload');
    $path = parse_url($url, PHP_URL_PATH) ?: '';
    $body = match ($path) {
        '/orders/refund' => ['refund' => ['id' => 'rf_1']],
        '/orders/page' => ['page' => ['number' => 0, 'size' => 0, 'orders' => []]],
        '/orders/send_invoice', '/orders/send_receipt' => [
            'order' => ['id' => 'or_1', 'status' => 'preparing'],
            'delivery' => [],
        ],
        default => str_starts_with($path, '/orders/')
            ? ['order' => ['id' => 'or_1', 'status' => 'preparing']]
            : ['ok' => true],
    };
    return [
        'status' => 200,
        'body' => json_encode($body),
        'headers' => ['content-type' => 'application/json'],
    ];
};

$client = new Client('test-key', 'https://api.inttegro.com', 5, $adapter);

$client->orders->create(['number' => 'ORDER-1']);
$client->orders->createLegacy(['number' => 'ORDER-2']);
$client->orders->lookup('or_1');
$client->orders->update(['order_id' => 'or_1', 'number' => 'ORDER-1-REV2']);
$client->orders->pay(['order_id' => 'or_1']);
$client->orders->confirmPayment(['order_id' => 'or_1', 'token' => '123456']);
$client->orders->requestConfirmation('or_1');
$client->orders->finalize('or_1');
$client->orders->sendInvoice(['order_id' => 'or_1']);
$client->orders->sendReceipt(['order_id' => 'or_1']);
$client->orders->complete(['order_id' => 'or_1']);
$client->orders->cancel('or_1');
$client->orders->refund([
    'order_id' => 'or_1',
    'reason' => 'requested_by_customer',
    'line_items' => [[
        'order_line_item_id' => 'oli_1',
        'refund_amount' => ['currency' => 'ghs', 'value' => 100],
    ]],
]);
$client->orders->page([]);

$client->paymentMethods->tokenize(['type' => 'mobile_money']);
$client->paymentMethods->verify('pm_1');
$client->paymentMethods->confirmVerification(['payment_method_id' => 'pm_1', 'token' => '123456']);
$client->paymentMethods->lookup('pm_1');
$client->paymentMethods->page(['customer_id' => 'cu_1']);
$client->paymentMethods->update(['payment_method_id' => 'pm_1', 'active' => true]);
$client->paymentMethods->activate('pm_1');
$client->paymentMethods->disactivate('pm_1');
$client->paymentMethods->archive('pm_1');
$client->paymentMethods->unarchive('pm_1');
$client->paymentMethods->delete('pm_1');
$client->paymentMethods->settings();

$client->payouts->setDestinations(['ghs' => 'dest']);
$client->payouts->settings();
$client->payouts->disableAutomatic();
$client->payouts->enableAutomatic();
$client->payouts->enableFx();
$client->payouts->disableFx();
$client->payouts->page([]);
$client->payouts->schedule([
    'destination_id' => 'fa_1',
    'max_amount' => 1,
    'reference' => 'PAYOUT-1',
]);
$client->payouts->lookup('po_1');
$client->payouts->cancel('po_1');

$client->balanceTransactions->lookup('bt_1');
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
$client->financialAccounts->reconnect('fa_1');

$client->fileReferences->reconcile([
    'resource' => ['type' => 'product', 'id' => 'prod_1'],
    'file_ids' => ['file_1'],
]);

$client->keys->generate(['label' => 'Production']);
$client->keys->page(['number' => 1, 'size' => 20]);
$client->keys->lookup('sk_1');
$client->keys->update(['secret_key_id' => 'sk_1', 'label' => 'Checkout']);
$client->keys->destroy('sk_1');
$client->keys->usage(['secret_key_id' => 'sk_1', 'number' => 1, 'size' => 20]);

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
$client->chimes->page(['page_number' => 1, 'page_size' => 20]);
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

$client->purchaseIntents->create([
    'product_id' => 'prod_1',
    'price_id' => 'pr_1',
    'quantity' => ['min' => 1, 'max' => 5],
]);
$client->purchaseIntents->update(['id' => 'sale_1', 'quantity' => ['min' => 1, 'max' => 3]]);
$client->purchaseIntents->cancel('sale_1');
$client->purchaseIntents->lookup('sale_1');
$client->purchaseIntents->page(['page_number' => 1, 'page_size' => 20]);

$client->spec->countries();
$client->balances->get();

$paths = array_map(fn($req) => parse_url($req['url'], PHP_URL_PATH), $requests);
$expected = [
    '/orders/create',
    '/orders/new',
    '/orders/lookup',
    '/orders/update',
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
    '/payment_methods/page',
    '/payment_methods/update',
    '/payment_methods/activate',
    '/payment_methods/disactivate',
    '/payment_methods/archive',
    '/payment_methods/unarchive',
    '/payment_methods/delete',
    '/payment_methods/settings',
    '/payouts/set_destinations',
    '/payouts/settings',
    '/payouts/disable',
    '/payouts/enable',
    '/payouts/enable_fx',
    '/payouts/disable_fx',
    '/payouts/page',
    '/payouts/schedule',
    '/payouts/lookup',
    '/payouts/cancel',
    '/balance_transactions/lookup',
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
    '/financial_accounts/reconnect',
    '/file_references/reconcile',
    '/keys/generate',
    '/keys/page',
    '/keys/lookup',
    '/keys/update',
    '/keys/destroy',
    '/keys/usage',
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
    '/chimes/page',
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
    '/purchase_intents/create',
    '/purchase_intents/update',
    '/purchase_intents/cancel',
    '/purchase_intents/lookup',
    '/purchase_intents/page',
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
            'url' => 'https://studio.inttegro.com/e/invalid_api_key',
            'message' => 'invalid key',
            'detail' => 'API key is missing or invalid.',
            'fix_code' => 'check_api_key',
            'cause' => 'authentication_failure',
        ]),
        'headers' => ['content-type' => 'application/json'],
    ];
};

$errorClient = new Client('bad-key', 'https://api.inttegro.com', 5, $errorAdapter);

$caught = false;
try {
    $errorClient->orders->lookup('or_123');
} catch (AuthenticationError $e) {
    $caught = true;
    assertEquals(401, $e->status);
}

assertTrue($caught, 'AuthenticationError was not raised');

$order = $client->orders->create(['number' => 'ORDER-3']);
assertTrue($order instanceof \Inttegro\Order);
assertEquals('or_1', $order->id);

echo "All tests passed\n";
