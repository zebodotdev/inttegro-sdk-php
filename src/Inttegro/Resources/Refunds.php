<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;

/**
 * Refunds resource for managing order refunds.
 *
 * Request arrays use the API's documented `snake_case` field names. Successful responses
 * are returned as immutable values from the corresponding singular resource namespace.
 */
class Refunds
{
    /**
     * Creates the refunds resource client.
     *
     * @param HttpClient $http Shared authenticated HTTP transport used by this resource client.
     */
    public function __construct(private HttpClient $http)
    {
    }

    /**
     * Create a refund for paid order line items.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @param ?string $idempotencyKey Optional idempotency key for safely retrying the same logical write.
     * @return \Inttegro\Refund\Refund The created refund.
     */
    public function create(array $payload, ?string $idempotencyKey = null): \Inttegro\Refund\Refund
    {
        return $this->http->postResource('/refunds/create', \Inttegro\Refund\Refund::class, 'refund',
            $payload,
            $this->idempotencyHeaders($idempotencyKey)
        );
    }

    /**
     * Cancel a pending refund.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param string $refundId Unique identifier of the refund.
     * @param ?string $idempotencyKey Optional idempotency key for safely retrying the same logical write.
     * @return \Inttegro\Refund\Refund The canceled refund.
     */
    public function cancel(string $refundId, ?string $idempotencyKey = null): \Inttegro\Refund\Refund
    {
        return $this->http->postResource('/refunds/cancel', \Inttegro\Refund\Refund::class, 'refund',
            ['refund_id' => $refundId],
            $this->idempotencyHeaders($idempotencyKey)
        );
    }

    /**
     * Look up a refund by ID.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param string $refundId Unique identifier of the refund.
     * @return \Inttegro\Refund\Refund The requested refund.
     */
    public function lookup(string $refundId): \Inttegro\Refund\Refund
    {
        return $this->http->postResource('/refunds/lookup', \Inttegro\Refund\Refund::class, 'refund', ['refund_id' => $refundId]);
    }

    /**
     * Page through refunds.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @return \Inttegro\Refund\Page A typed page of matching refunds.
     */
    public function page(array $payload = []): \Inttegro\Refund\Page
    {
        return $this->http->postResource('/refunds/page', \Inttegro\Refund\Page::class, 'page', $payload);
    }

    private function idempotencyHeaders(?string $idempotencyKey): array
    {
        return $idempotencyKey ? ['Idempotency-Key' => $idempotencyKey] : [];
    }
}
