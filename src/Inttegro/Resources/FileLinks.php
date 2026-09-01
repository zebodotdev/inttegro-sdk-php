<?php

namespace Inttegro\Resources;

use Inttegro\FileDownload;
use Inttegro\HttpClient;
use Inttegro\ResponseObject;

class FileLinks
{
    public function __construct(private HttpClient $http)
    {
    }

    public function create(array $payload, array $options = []): ResponseObject
    {
        return $this->http->postWithHeaders('/file_links/create', $payload, $this->headers($options));
    }

    public function lookup(string $id): ResponseObject
    {
        return $this->http->post('/file_links/lookup', ['id' => $id]);
    }

    public function page(array $payload = []): ResponseObject
    {
        return $this->http->post('/file_links/page', $payload);
    }

    public function revoke(array $payload, array $options = []): ResponseObject
    {
        return $this->http->postWithHeaders('/file_links/revoke', $payload, $this->headers($options));
    }

    public function open(string $url, ?string $saveTo = null): FileDownload
    {
        $download = $this->http->getBinaryPublic($url);
        if ($saveTo !== null) {
            $download->saveTo($saveTo);
        }
        return $download;
    }

    private function headers(array $options): array
    {
        return isset($options['idempotency_key']) ? ['Idempotency-Key' => $options['idempotency_key']] : [];
    }
}
