## [Unreleased]

## [8.1.0] - 2026-09-12

- Added opt-in response envelopes that expose status, headers, request IDs,
  retry hints, and response metadata without changing existing resource return
  values.

## [8.0.0] - 2026-09-11

- Breaking: moved resource models and enums from the `Inttegro` root into singular resource namespaces such as `Inttegro\Payment\Payment`, with one public type per file.
- Breaking: removed the obsolete root and plural-namespace compatibility aliases.
- Added focused question and accessor methods for common resource state, actionability, amounts, customers, and payment methods.
- Expanded and automatically verified the API documentation for resource types, enum cases, and client operations.

## [7.0.0] - 2026-09-10

- Breaking: replaced generic arrays with named models for balances, purchase intents, products, payment methods, payments, and orders.
- Breaking: exposed API timestamps as `DateTimeImmutable` values and accepted `DateTimeInterface` values in timestamp request fields.
- Removed legacy order and property compatibility aliases; canonical resource methods and typed camelCase properties are now the only public surface.

## [6.0.1] - 2026-09-08

- Tightened financial-account and payment-method response models to exclude internal platform fields.

## [6.0.0] - 2026-09-08

- Breaking: removed `PurchaseIntent::$applicationId` and `PurchaseIntentMerchant::$appId` so purchase-intent responses no longer expose application identity.
- Documented `camelCase` as the canonical PHP identifier and typed-property convention, with `snake_case` reserved for native request arrays and serialized API data.
- Deprecated legacy snake_case property aliases ahead of their removal in the next major release.
- Added versioned PHP API-reference publishing at `php.inttegro.dev`.

## [5.3.0] - 2026-09-06

- Added opt-in, typed error reporting to application-owned collectors with privacy-safe payloads, stable fingerprints, isolated reporter failures, and no reporting work when unconfigured.

## [5.2.0] - 2026-09-04

- Added vendor-neutral OpenTelemetry spans for logical SDK operations, HTTP attempts, response receipt, decoding, and safe failure categories.
- Added W3C trace-context propagation plus global or per-client tracer-provider and propagator configuration.
- Kept request bodies, credentials, resource identifiers, dynamic URLs, and exception details out of telemetry.

## [5.1.0] - 2026-09-03

- Added focused `Inttegro\Wallets` and `Inttegro\BankAccounts` namespaces for financial-account variants.
- Preserved the generated root value types as compatibility aliases.

## [5.0.0] - 2026-09-03

- Breaking: removed the generic `Inttegro\Enums` namespace and exposed native backed enums directly from `Inttegro`.

## [4.0.0] - 2026-09-03

- Breaking: renamed order-prefixed payment value objects to semantic `Payment`, `PaymentAttempt`, `PaymentMethodSnapshot`, and payment payout-configuration types.
- Added focused money amount and inline price types for request and response contracts.
- Preserved direct domain returns from every resource method; transport envelopes remain internal.

## [3.0.1] - 2026-09-03

- Corrected the user agent, README, and resource examples to show direct domain return values.

## [3.0.0] - 2026-09-03

- Breaking: resource methods now return immutable, typed domain value objects and pages instead of response wrappers and arrays.
- Removed the public response object and response-oriented order types.
- Named the shared immutable base `DomainValue` so domain types do not inherit from an object- or model-oriented public abstraction.
- Renamed payment result status constants to `PaymentResultStatus`.

## [2.0.0] - 2026-09-02

- Breaking: moved order domain types from `Inttegro\Models` to the root `Inttegro` namespace.

## [1.0.0] - 2026-09-01

- Breaking: renamed the package, namespace, and base exception to `inttegro/sdk`, `Inttegro`, and `InttegroError`.
- Aligned package metadata, examples, and the transport user agent with the public Inttegro service name.
