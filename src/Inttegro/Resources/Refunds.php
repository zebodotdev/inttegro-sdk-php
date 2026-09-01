<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;
use Inttegro\ResponseObject;

/** Refunds resource for managing order refunds. */
class Refunds
{
    public function __construct(private HttpClient $http)
    {
    }

    /** Create a refund for paid order line items. */
    public function create(array $payload, ?string $idempotencyKey = null): ResponseObject
    {
        return $this->http->postWithHeaders(
            '/refunds/create',
            $payload,
            $this->idempotencyHeaders($idempotencyKey)
        );
    }

    /** Cancel a pending refund. */
    public function cancel(string $refundId, ?string $idempotencyKey = null): ResponseObject
    {
        return $this->http->postWithHeaders(
            '/refunds/cancel',
            ['refund_id' => $refundId],
            $this->idempotencyHeaders($idempotencyKey)
        );
    }

    /** Look up a refund by ID. */
    public function lookup(string $refundId): ResponseObject
    {
        return $this->http->post('/refunds/lookup', ['refund_id' => $refundId]);
    }

    /** Page through refunds. */
    public function page(array $payload = []): ResponseObject
    {
        return $this->http->post('/refunds/page', $payload);
    }

    private function idempotencyHeaders(?string $idempotencyKey): array
    {
        return $idempotencyKey ? ['Idempotency-Key' => $idempotencyKey] : [];
    }
}
