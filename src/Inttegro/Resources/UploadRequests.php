<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;

class UploadRequests
{
    public function __construct(private HttpClient $http)
    {
    }

    public function create(array $payload, array $options = []): \Inttegro\UploadRequest
    {
        return $this->http->postResource('/upload_requests/create', \Inttegro\UploadRequest::class, 'upload_request', $payload, $this->headers($options));
    }

    public function lookup(string $id): \Inttegro\UploadRequest
    {
        return $this->http->postResource('/upload_requests/lookup', \Inttegro\UploadRequest::class, 'upload_request', ['id' => $id]);
    }

    public function page(array $payload = []): \Inttegro\UploadRequestPage
    {
        return $this->http->postResource('/upload_requests/page', \Inttegro\UploadRequestPage::class, 'page', $payload);
    }

    public function cancel(array $payload, array $options = []): \Inttegro\UploadRequest
    {
        return $this->http->postResource('/upload_requests/cancel', \Inttegro\UploadRequest::class, 'upload_request', $payload, $this->headers($options));
    }

    public function review(array $payload, array $options = []): \Inttegro\UploadRequest
    {
        return $this->http->postResource('/upload_requests/review', \Inttegro\UploadRequest::class, 'upload_request', $payload, $this->headers($options));
    }

    public function fulfill(array $payload): \Inttegro\UploadFulfillment
    {
        return $this->http->postMultipartValue(
            $payload['upload_url'],
            \Inttegro\UploadFulfillment::class,
            [],
            ['file' => $payload['file']],
            [],
            false,
            'upload_requests.upload'
        );
    }

    private function headers(array $options): array
    {
        return isset($options['idempotency_key']) ? ['Idempotency-Key' => $options['idempotency_key']] : [];
    }
}
