# Zebo Commerce PHP SDK

Lightweight PHP client for the Zebo Commerce API. Covers orders, payments, payouts, OTP, payment methods, chimes, balance transactions, financial accounts, platform apps/keys/sessions, and specs.

## Installation

```bash
composer require zebo/commerce-sdk
```

For local development in this repo:

```bash
composer install --no-dev
```

## Quick start

```php
require __DIR__ . '/src/autoload.php';

use Commerce\Client;

$client = new Client(getenv('COMMERCE_API_KEY'));

$order = $client->orders->create([
    'customer_data' => [
        'name' => 'Akua Mensah',
        'phone_number' => '+233544998605',
    ],
    'payment_method_data' => [
        'type' => 'mobile_money',
        'mobile_money' => [
            'issuer' => 'mtn',
            'number' => '0544998605',
        ],
    ],
    'line_items' => [[
        'type' => 'product',
        'product' => [
            'name' => 'Monthly Subscription',
            'price' => ['currency' => 'ghs', 'value' => 5000],
            'quantity' => 1,
        ],
    ]],
]);

echo $order['order']['id'] . PHP_EOL;
```

Responses are wrapped so you can use either property or array access (`$order->order->id` or `$order['order']->id`).

## Examples

### Create an order with payment

```php
$order = $client->orders->create([
    'idempotency_key' => 'order_checkout_abc123_' . time(),
    'customer_data' => ['name' => 'Customer', 'phone_number' => '+233200000000'],
    'payment_method_data' => [
        'type' => 'mobile_money',
        'mobile_money' => ['issuer' => 'mtn', 'number' => '0544998605'],
    ],
    'line_items' => [[
        'type' => 'product',
        'product' => [
            'name' => 'Utility Sneakers',
            'quantity' => 1,
            'price' => ['currency' => 'ghs', 'value' => 20000],
        ],
    ]],
    'execute_payment' => true,
]);

echo $order['order']['id'];
```

### Hosted checkout (orders->new shortcut)

```php
$result = $client->orders->new([
    'finalize' => true,
    'customer_data' => ['name' => 'Jane Doe'],
    'line_items' => [
        [
            'type' => 'product',
            'product' => [
                'name' => 'Subscription',
                'quantity' => 1,
                'price' => ['currency' => 'ghs', 'value' => 5000],
            ],
        ],
    ],
]);

// Redirect to $result->order->invoice->format->web->url
```

### Handle errors

```php
use Commerce\AuthenticationError;
use Commerce\RateLimitError;
use Commerce\APIError;

try {
    $client->orders->lookup('ord_missing');
} catch (AuthenticationError $e) {
    error_log('Check API key: ' . $e->getMessage());
} catch (RateLimitError $e) {
    error_log('Retry after ' . $e->retryAfter . 's');
} catch (APIError $e) {
    error_log('API error ' . $e->status . ': ' . $e->getMessage());
}
```

### Tokenize and charge a saved payment method

```php
$pm = $client->paymentMethods->tokenize([
    'type' => 'mobile_money',
    'mobile_money' => ['issuer' => 'mtn', 'number' => '0544998605'],
]);

$client->paymentMethods->verify($pm['payment_method']['id']);

$payment = $client->orders->pay([
    'order_id' => 'ord_123',
    'payment_method_id' => $pm['payment_method']['id'],
]);

if (!empty($payment['requires_confirmation'])) {
    $client->orders->confirmPayment(['order_id' => $payment['order_id'], 'token' => '123456']);
}
```

### OTP flows

```php
$txn = $client->otp->initiate([
    'recipient' => '+233241234567',
    'idempotency_key' => 'otp_login_' . time(),
    'purpose' => 'login',
]);

$verification = $client->otp->verify([
    'transaction_id' => $txn['transaction_id'] ?? $txn['transaction']['id'] ?? null,
    'token' => '123456',
]);

// Lookup or cancel as shown in Studio samples
$client->otp->lookup([
    'transaction_id' => $txn['transaction_id'] ?? $txn['transaction']['id'] ?? null,
]);
$client->otp->cancel([
    'transaction_id' => $txn['transaction_id'] ?? $txn['transaction']['id'] ?? null,
    'reason' => 'user_requested_new_code',
]);
```

### Payout settings

```php
$settings = $client->payouts->setDestinations([
    'ghs' => 'momo:0544998605',
    'usd' => 'bank:0011223344',
]);
```

### Platform: apps, keys, sessions

```php
$app = $client->platform->createApp(['name' => 'My App']);
$key = $client->platform->generateKey(['app_id' => $app['app']['id'], 'name' => 'Server key']);
$session = $client->platform->newSession(['app_id' => $app['app']['id']]);
```

## Available resources

- `$client->orders->create|lookup|pay|confirmPayment|requestConfirmation|finalize|complete|cancel|refund|page`
- `$client->paymentMethods->tokenize|verify|confirmVerification|lookup|delete|settings`
- `$client->payouts->setDestinations|settings|disableAutomatic|enableFx|disableFx|page`
- `$client->balanceTransactions->page`
- `$client->financialAccounts->create|lookup|connect|archive|page|verify`
- `$client->chimes->send|lookup|schedule`
- `$client->otp->initiate|verify|lookup|cancel`
- `$client->platform->createApp|generateKey|newSession`
- `$client->spec->countries`

## Development

From `sdks/php`:

```bash
php tests/run.php
```

CI and release workflows live in `sdks/php/.github`. Configure your Packagist automation separately when ready to publish.
