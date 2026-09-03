<?php

namespace Inttegro\Resources;

use Inttegro\FileDownload;
use Inttegro\HttpClient;

class Files
{
    public function __construct(private HttpClient $http)
    {
    }

    public function create(array $payload, array $options = []): \Inttegro\File
    {
        $file = $payload['file'];
        unset($payload['file']);
        $idempotencyKey = $options['idempotency_key'] ?? $payload['idempotency_key'] ?? null;
        unset($payload['idempotency_key']);
        return $this->http->postMultipartResource(
            '/files/create',
            \Inttegro\File::class,
            'file',
            $payload,
            ['file' => $file],
            $this->headers($idempotencyKey)
        );
    }

    public function lookup(string $fileId): \Inttegro\File
    {
        return $this->http->postResource('/files/lookup', \Inttegro\File::class, 'file', ['file_id' => $fileId]);
    }

    public function page(array $payload = []): \Inttegro\FilePage
    {
        return $this->http->postResource('/files/page', \Inttegro\FilePage::class, 'page', $payload);
    }

    public function contents(array $payload): FileDownload
    {
        return $this->http->postBinaryJson('/files/contents', $payload);
    }

    public function delete(string $fileId): \Inttegro\File
    {
        return $this->http->postResource('/files/delete', \Inttegro\File::class, 'file', ['file_id' => $fileId]);
    }

    private function headers(?string $idempotencyKey): array
    {
        return $idempotencyKey !== null ? ['Idempotency-Key' => $idempotencyKey] : [];
    }
}
