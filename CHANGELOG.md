## [Unreleased]

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
