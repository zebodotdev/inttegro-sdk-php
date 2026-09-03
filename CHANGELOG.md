## [Unreleased]

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
