<?php

namespace Commerce\Resources;

use Commerce\FileDownload;
use Commerce\HttpClient;
use Commerce\ResponseObject;

class Files
{
    public function __construct(private HttpClient $http)
    {
    }

    public function create(array $payload, array $options = []): ResponseObject
    {
        $file = $payload['file'];
        unset($payload['file']);
        $idempotencyKey = $options['idempotency_key'] ?? $payload['idempotency_key'] ?? null;
        unset($payload['idempotency_key']);
        return $this->http->postMultipart('/files/create', $payload, ['file' => $file], $this->headers($idempotencyKey));
    }

    public function lookup(string $fileId): ResponseObject
    {
        return $this->http->post('/files/lookup', ['file_id' => $fileId]);
    }

    public function page(array $payload = []): ResponseObject
    {
        return $this->http->post('/files/page', $payload);
    }

    public function contents(array $payload): FileDownload
    {
        return $this->http->postBinaryJson('/files/contents', $payload);
    }

    public function delete(string $fileId): ResponseObject
    {
        return $this->http->post('/files/delete', ['file_id' => $fileId]);
    }

    private function headers(?string $idempotencyKey): array
    {
        return $idempotencyKey !== null ? ['Idempotency-Key' => $idempotencyKey] : [];
    }
}
