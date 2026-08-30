# Zebo Commerce PHP SDK

Lightweight PHP client for the Zebo Commerce API. Covers orders, payments, payouts, OTP, payment methods, chimes, balance transactions, financial accounts, apps, and specs.

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
    'payout_settings' => [
        'destination' => [
            'financial_account_id' => 'fa_1234567890abcdef',
        ],
        'enable_fx' => false,
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
    'payout_settings' => [
        'destination' => [
            'financial_account_id' => 'fa_1234567890abcdef',
        ],
        'enable_fx' => false,
    ],
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
    $client->orders->lookup('or_missing');
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
    'order_id' => 'or_123',
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
    'sender' => 'Acme',
    'service_name' => 'Acme Bank',
    'purpose' => 'login',
]);

$verification = $client->otp->verify([
    'transaction_id' => $txn['transaction_id'] ?? $txn['transaction']['id'] ?? null,
    'recipient' => '+233241234567',
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
    'usd' => 'fa_bank_account',
]);
```

### Financial accounts

```php
$account = $client->financialAccounts->connect([
    'label' => 'Primary GHS Bank Account',
    'type' => 'bank_account',
    'reference' => 'BANK-GHS-001',
    'currency' => 'ghs',
    'owner' => [
        'name' => 'Jane Smith',
        'address' => [
            'name' => 'Business Address',
            'line_1' => '456 Business Road',
            'city' => 'Accra',
            'region' => 'Greater Accra',
            'country' => 'Ghana',
        ],
    ],
    'custom_data' => ['merchant_id' => 'merch_123'],
    'pull_configuration' => ['enabled' => true, 'mandate' => []],
    'bank_account' => [
        'type' => 'ghana_bank_account',
        'ghana_bank_account' => [
            'number' => '1234567890',
            'sort_code' => '040127',
            'holder' => [
                'name' => 'Jane Smith',
                'address' => [
                    'name' => 'Business Address',
                    'line_1' => '456 Business Road',
                    'city' => 'Accra',
                    'region' => 'Greater Accra',
                    'country' => 'Ghana',
                ],
            ],
        ],
    ],
]);

$client->financialAccounts->disablePush([
    'account_id' => 'fa_1234567890abcdef',
    'unset_as_payout_destination' => true,
]);

$client->financialAccounts->disconnect([
    'account_id' => 'fa_1234567890abcdef',
    'unset_as_payout_destination' => true,
]);

$client->financialAccounts->page([
    'page_number' => 1,
    'page_size' => 50,
]);
```

### Customers

```php
$customer = $client->customers->create([
    'name' => 'Jane Doe',
    'email_address' => 'jane@example.com',
    'phone_number' => '+233501234567',
]);

$existing = $client->customers->lookup('cu_1234567890abcdef');
$page = $client->customers->page(['page_number' => 1, 'page_size' => 50]);
```

### Products

```php
$product = $client->products->create([
    'type' => 'physical',
    'name' => 'Premium Cotton T-Shirt',
]);

$client->products->addPrice([
    'product_id' => $product['product']['id'],
    'amount' => ['currency' => 'ghs', 'value' => 5000],
    'set_as_default' => true,
]);

$productsPage = $client->products->page(['page_number' => 1, 'page_size' => 50]);

$client->products->publish($product['product']['id']);
```

### Prices

```php
$price = $client->prices->create([
    'currency' => 'USD',
    'amount' => 1999,
    'label' => 'Standard pricing',
]);

$client->prices->update([
    'price_id' => $price['price']['id'],
    'label' => 'Premium pricing',
]);
```

### Apps

```php
$app = $client->apps->create(['name' => 'My App']);
$currentApp = $client->apps->lookup();
$updatedApp = $client->apps->update(['alias' => 'my-app']);
```

## Available resources

- `$client->orders->create|new|lookup|update|pay|confirmPayment|requestConfirmation|finalize|complete|cancel|refund|page`
- `$client->paymentMethods->tokenize|verify|confirmVerification|lookup|page|update|activate|disactivate|archive|unarchive|delete|settings`
- `$client->payouts->setDestinations|settings|disableAutomatic|enableAutomatic|enableFx|disableFx|page|schedule|lookup|cancel`
- `$client->balanceTransactions->lookup|page`
- `$client->financialAccounts->create|lookup|connect|archive|page|verify|update|enablePush|disablePush|enablePull|disablePull|disconnect|reconnect`
- `$client->fileReferences->reconcile`
- `$client->customers->create|lookup|page`
- `$client->keys->generate|page|lookup|update|destroy|usage`
- `$client->prices->create|lookup|page|update|activate|deactivate`
- `$client->products->create|addPrice|setDefaultUnitPrice|lookup|update|publish|unpublish|archive|page`
- `$client->purchaseIntents->create|update|cancel|lookup|page`
- `$client->chimes->send|lookup|page|schedule|broadcast`
- `$client->schedules->lookup|cancel`
- `$client->broadcasts->lookup|cancel`
- `$client->otp->initiate|verify|lookup|cancel`
- `$client->balances->get`
- `$client->apps->create|lookup|update`
- `$client->spec->countries`

## Development

From `sdks/php`:

```bash
php tests/run.php
```

CI and release workflows live in `sdks/php/.github`. Configure your Packagist automation separately when ready to publish.
