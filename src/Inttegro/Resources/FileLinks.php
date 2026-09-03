<?php

namespace Inttegro\Resources;

use Inttegro\FileDownload;
use Inttegro\HttpClient;

class FileLinks
{
    public function __construct(private HttpClient $http)
    {
    }

    public function create(array $payload, array $options = []): \Inttegro\FileLinkCreation
    {
        return $this->http->postValue('/file_links/create', \Inttegro\FileLinkCreation::class, $payload, $this->headers($options));
    }

    public function lookup(string $id): \Inttegro\FileLink
    {
        return $this->http->postResource('/file_links/lookup', \Inttegro\FileLink::class, 'file_link', ['id' => $id]);
    }

    public function page(array $payload = []): \Inttegro\FileLinkPage
    {
        return $this->http->postResource('/file_links/page', \Inttegro\FileLinkPage::class, 'page', $payload);
    }

    public function revoke(array $payload, array $options = []): \Inttegro\FileLink
    {
        return $this->http->postResource('/file_links/revoke', \Inttegro\FileLink::class, 'file_link', $payload, $this->headers($options));
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
