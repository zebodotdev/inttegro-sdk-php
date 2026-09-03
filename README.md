# Inttegro PHP SDK

[![OpenSSF Scorecard](https://api.scorecard.dev/projects/github.com/zebodotdev/inttegro-sdk-php/badge)](https://scorecard.dev/viewer/?uri=github.com/zebodotdev/inttegro-sdk-php)

The official PHP client for building server-side Inttegro integrations.

> **Fastest, most modern path:** connect an agent to [Inttegro MCP](https://studio.inttegro.com/inttegro-mcp) at `https://mcp.inttegro.com`, then ask it to run `design_integration`. It will produce an implementation and test plan for your application. Use this SDK when you are ready to connect that plan to your PHP service.

All official Inttegro SDKs expose the same API capabilities. This package adds PHP-native domain values and enum support.

## Install

Requires PHP 8.1 or newer.

```bash
composer require inttegro/sdk
```

Store your secret key in the server environment:

```bash
export INTTEGRO_API_KEY="your_secret_key"
```

Never put the key in browser code, a mobile app, or source control. The client uses `https://api.inttegro.com` by default.

## Create a hosted checkout

Create and finalize an order, then send the customer to its hosted invoice URL:

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use Inttegro\APIError;
use Inttegro\Client;
use Inttegro\Enums\ProductType;

$inttegro = new Client(getenv('INTTEGRO_API_KEY'));

try {
    $order = $inttegro->orders->create([
        'request_meta' => ['idempotency_key' => 'checkout-cart-123'],
        'customer_data' => [
            'name' => 'Akua Mensah',
            'email_address' => 'akua@example.com',
            'phone_number' => '+233544998605',
        ],
        'finalize' => true,
        'checkout_settings' => [
            'redirect_url' => 'https://example.com/orders/complete',
            'cancel_url' => 'https://example.com/cart',
        ],
        'line_items' => [[
            'type' => 'product',
            'product' => [
                'type' => ProductType::Digital,
                'name' => 'Monthly subscription',
                'quantity' => 1,
                'price' => ['currency' => 'ghs', 'value' => 5000],
            ],
        ]],
    ]);

    $checkoutUrl = $order->invoice?->format?->web?->url
        ?? throw new RuntimeException('Order did not include a checkout URL');
    echo $order->id . ' ' . $checkoutUrl . PHP_EOL;
} catch (APIError $error) {
    error_log(($error->code ?? 'api_error') . ': ' . ($error->detail ?? $error->getMessage()));
    throw $error;
}
```

Amounts use integer minor units: `5000` GHS is GHS 50.00. Reuse the same idempotency key when retrying the same logical write. If you omit one, the SDK generates a UUIDv7 key for mutating calls.

## Work with the API

The SDK covers orders and checkout, customers, products and prices, purchase intents, payment methods, balances, payouts and refunds, notifications, files, application settings, keys, and country specifications. Resources use camel-case properties such as `purchaseIntents` and `paymentMethods`.

PHP-specific features:

- Native array request payloads and backed enums for public API values.
- Immutable typed domain values returned directly by every resource operation, with transport envelopes decoded internally.
- Property and `ArrayAccess` syntax, `toArray()`, and JSON serialization on domain values.
- No production Composer dependencies beyond PHP itself; HTTP uses cURL.
- Configurable timeout, base URL, and injectable adapter for tests.
- Structured authentication, rate-limit, network, timeout, and API exceptions.

See the [API reference](https://studio.inttegro.com/api-reference) for request fields and lifecycle rules, [errors](https://studio.inttegro.com/errors) for recovery guidance, and [idempotency](https://studio.inttegro.com/idempotency) for safe retries.

## Verify a release

Packagist versions resolve to immutable Git commit references. The corresponding GitHub release is the canonical record and contains an archive of that exact commit, SHA-256 checksums, and a Sigstore attestation tied to the release workflow.

```bash
sha256sum --check SHA256SUMS
gh attestation verify inttegro-sdk-php-3.0.1.tar.gz \
  --repo zebodotdev/inttegro-sdk-php
```

## Develop

```bash
composer install
php tests/run.php
```
