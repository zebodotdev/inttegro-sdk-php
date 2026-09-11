<?php

namespace Inttegro\Otp;


/**
 * Verification details associated with otp.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Verification extends \Inttegro\DomainValue
{
    /**
     * OTP transaction object returned by initiate, verify, and lookup endpoints.
     *
     * Required response field. PHP type: `\Inttegro\Otp\Transaction`; wire field: `transaction`
     * (`object`).
     *
     * @var \Inttegro\Otp\Transaction
     */
    public readonly \Inttegro\Otp\Transaction $transaction;

    /**
     * Details of a verification attempt.
     *
     * Required response field. PHP type: `\Inttegro\Otp\VerificationAttempt`; wire field:
     * `verification_attempt` (`object`).
     *
     * @var \Inttegro\Otp\VerificationAttempt
     */
    public readonly \Inttegro\Otp\VerificationAttempt $verificationAttempt;

    /**
     * Hydrates a Verification from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->transaction = \Inttegro\ValueHydrator::object($data['transaction'] ?? null, [\Inttegro\Otp\Transaction::class], false);
        $this->verificationAttempt = \Inttegro\ValueHydrator::object($data['verification_attempt'] ?? null, [\Inttegro\Otp\VerificationAttempt::class], false);
    }

    /**
     * Creates a Verification from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Verification value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
