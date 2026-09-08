# Inttegro PHP SDK

[![OpenSSF Scorecard](https://api.scorecard.dev/projects/github.com/zebodotdev/inttegro-sdk-php/badge)](https://scorecard.dev/viewer/?uri=github.com/zebodotdev/inttegro-sdk-php)

The official PHP client for building server-side Inttegro integrations.

[API documentation](https://php.inttegro.dev/) · [Integration guides](https://studio.inttegro.com/sdks/php)

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
use Inttegro\ProductType;
use Inttegro\Money\Currency;
use Inttegro\PriceParams;

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
                'price' => new PriceParams(Currency::GHS, 5000),
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

## Observe SDK operations

The SDK emits vendor-neutral OpenTelemetry spans through your application's provider. It never configures an exporter or sends telemetry by itself. The global provider is used automatically, or inject the provider and propagator owned by your application:

```php
$inttegro = new Client(
    apiKey: getenv('INTTEGRO_API_KEY'),
    tracerProvider: $tracerProvider,
    propagator: $propagator,
);
```

Spans are named after logical operations such as `inttegro.orders.create`. HTTP attempts, response receipt, and decoding are span events. API keys, bodies, resource IDs, dynamic URLs, and exception messages are never recorded. See [SDK observability](https://studio.inttegro.com/sdk-observability) for the complete contract and pass `telemetryEnabled: false` when needed.

### Report SDK failures

Provide an application-owned reporter to receive one immutable, typed, privacy-safe report after an SDK operation finally fails. The default `unexpected` policy reports transport, timeout, decoding, SDK, `unknown_error`, and server-side failures while leaving normal 4xx API errors alone:

```php
use Inttegro\Client;
use Inttegro\ErrorReport;

$inttegro = new Client(
    apiKey: getenv('INTTEGRO_API_KEY'),
    errorReporter: static fn (ErrorReport $report) => $errorCollector->enqueue($report),
);
```

Pass `errorReportingPolicy: 'all'` to include expected API failures; cancellations are never reported. `ErrorReport` implements `JsonSerializable`. Reports contain the logical operation, static route, server host, status and request IDs when available, duration, safe API error codes, SDK identity, stable fingerprint, exception type, and trace IDs when tracing is active. They exclude credentials, headers, bodies, resource IDs, dynamic URLs, exception messages, and stack traces. Reporter failures are isolated and the original SDK exception is still thrown.

Error reporting is completely opt-in. Without `errorReporter`, the SDK does not calculate report metadata, create an event ID or timestamp, allocate a report, or serialize a payload.

## Work with the API

The SDK covers orders and checkout, customers, products and prices, purchase intents, payment methods, balances, payouts and refunds, notifications, files, application settings, keys, and country specifications.

### Naming conventions

The SDK keeps PHP identifiers distinct from the API's JSON field names:

```php
$paymentId = $transaction->paymentId;

$order = $inttegro->orders->pay([
    'order_id' => $orderId,
    'payment_method_id' => $paymentMethodId,
]);
```

- Client resources, method parameters, local variables, and typed domain properties use `camelCase`, such as `purchaseIntents`, `paymentMethods`, and `paymentId`.
- Native request arrays use the API's documented `snake_case` field names, such as `order_id` and `payment_method_id`.
- `ArrayAccess`, `toArray()`, and JSON serialization expose the API's `snake_case` wire representation.

Legacy snake_case property reads such as `$transaction->payment_id` remain available for backwards compatibility in the current major version. They are deprecated, are not declared typed properties, and will be removed in the next major release. Use `$transaction->paymentId` in all new code. Values represented by `GenericValue` are the exception: their schemas permit arbitrary object data, so they preserve the API's original keys.

PHP-specific features:

- Native array request payloads, typed amount and price values, and backed enums for public API values.
- Immutable typed domain values returned directly by every resource operation, with transport envelopes decoded internally.
- Typed property and `ArrayAccess` syntax, `toArray()`, and JSON serialization on domain values.
- cURL transport with the lightweight OpenTelemetry API for application-owned tracing.
- Configurable timeout, base URL, and injectable adapter for tests.
- Structured authentication, rate-limit, network, timeout, and API exceptions.

See the [API reference](https://studio.inttegro.com/api-reference) for request fields and lifecycle rules, [errors](https://studio.inttegro.com/errors) for recovery guidance, and [idempotency](https://studio.inttegro.com/idempotency) for safe retries.

## Verify a release

Packagist versions resolve to immutable Git commit references. The corresponding GitHub release is the canonical record and contains an archive of that exact commit, SHA-256 checksums, and a Sigstore attestation tied to the release workflow.

```bash
sha256sum --check SHA256SUMS
gh attestation verify inttegro-sdk-php-6.0.1.tar.gz \
  --repo zebodotdev/inttegro-sdk-php
```

## Develop

```bash
composer install
php tests/run.php
```
