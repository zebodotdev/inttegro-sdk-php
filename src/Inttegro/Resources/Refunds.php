<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;

/** Refunds resource for managing order refunds. */
class Refunds
{
    public function __construct(private HttpClient $http)
    {
    }

    /** Create a refund for paid order line items. */
    public function create(array $payload, ?string $idempotencyKey = null): \Inttegro\Refund
    {
        return $this->http->postResource('/refunds/create', \Inttegro\Refund::class, 'refund',
            $payload,
            $this->idempotencyHeaders($idempotencyKey)
        );
    }

    /** Cancel a pending refund. */
    public function cancel(string $refundId, ?string $idempotencyKey = null): \Inttegro\Refund
    {
        return $this->http->postResource('/refunds/cancel', \Inttegro\Refund::class, 'refund',
            ['refund_id' => $refundId],
            $this->idempotencyHeaders($idempotencyKey)
        );
    }

    /** Look up a refund by ID. */
    public function lookup(string $refundId): \Inttegro\Refund
    {
        return $this->http->postResource('/refunds/lookup', \Inttegro\Refund::class, 'refund', ['refund_id' => $refundId]);
    }

    /** Page through refunds. */
    public function page(array $payload = []): \Inttegro\RefundPage
    {
        return $this->http->postResource('/refunds/page', \Inttegro\RefundPage::class, 'page', $payload);
    }

    private function idempotencyHeaders(?string $idempotencyKey): array
    {
        return $idempotencyKey ? ['Idempotency-Key' => $idempotencyKey] : [];
    }
}
