<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;
use Inttegro\ResponseObject;

class UploadRequests
{
    public function __construct(private HttpClient $http)
    {
    }

    public function create(array $payload, array $options = []): ResponseObject
    {
        return $this->http->postWithHeaders('/upload_requests/create', $payload, $this->headers($options));
    }

    public function lookup(string $id): ResponseObject
    {
        return $this->http->post('/upload_requests/lookup', ['id' => $id]);
    }

    public function page(array $payload = []): ResponseObject
    {
        return $this->http->post('/upload_requests/page', $payload);
    }

    public function cancel(array $payload, array $options = []): ResponseObject
    {
        return $this->http->postWithHeaders('/upload_requests/cancel', $payload, $this->headers($options));
    }

    public function fulfill(array $payload): ResponseObject
    {
        return $this->http->postMultipart($payload['upload_url'], [], ['file' => $payload['file']], [], false);
    }

    private function headers(array $options): array
    {
        return isset($options['idempotency_key']) ? ['Idempotency-Key' => $options['idempotency_key']] : [];
    }
}
