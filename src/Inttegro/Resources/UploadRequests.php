<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;

/**
 * Client operations for Inttegro upload requests.
 *
 * Request arrays use the API's documented `snake_case` field names. Responses
 * are returned as immutable values from the corresponding singular namespace.
 */
class UploadRequests
{
    /**
     * Creates the upload requests resource client.
     *
     * @param HttpClient $http Shared authenticated HTTP transport used by this resource client.
     */
    public function __construct(private HttpClient $http)
    {
    }

    /**
     * Creates a new upload request.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @param array<string, mixed> $options Optional endpoint-specific request fields.
     * @return \Inttegro\UploadRequest\UploadRequest The created upload request.
     */
    public function create(array $payload, array $options = []): \Inttegro\UploadRequest\UploadRequest
    {
        return $this->http->postResource('/upload_requests/create', \Inttegro\UploadRequest\UploadRequest::class, 'upload_request', $payload, $this->headers($options));
    }

    /**
     * Retrieves the requested upload request.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param string $id ID value.
     * @return \Inttegro\UploadRequest\UploadRequest The requested upload request.
     */
    public function lookup(string $id): \Inttegro\UploadRequest\UploadRequest
    {
        return $this->http->postResource('/upload_requests/lookup', \Inttegro\UploadRequest\UploadRequest::class, 'upload_request', ['id' => $id]);
    }

    /**
     * Retrieves a paginated collection of upload requests.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @return \Inttegro\UploadRequest\Page A typed page of matching upload requests.
     */
    public function page(array $payload = []): \Inttegro\UploadRequest\Page
    {
        return $this->http->postResource('/upload_requests/page', \Inttegro\UploadRequest\Page::class, 'page', $payload);
    }

    /**
     * Cancels the upload request.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @param array<string, mixed> $options Optional endpoint-specific request fields.
     * @return \Inttegro\UploadRequest\UploadRequest The canceled upload request.
     */
    public function cancel(array $payload, array $options = []): \Inttegro\UploadRequest\UploadRequest
    {
        return $this->http->postResource('/upload_requests/cancel', \Inttegro\UploadRequest\UploadRequest::class, 'upload_request', $payload, $this->headers($options));
    }

    /**
     * Records a review decision for the upload request.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @param array<string, mixed> $options Optional endpoint-specific request fields.
     * @return \Inttegro\UploadRequest\UploadRequest The resulting upload request.
     */
    public function review(array $payload, array $options = []): \Inttegro\UploadRequest\UploadRequest
    {
        return $this->http->postResource('/upload_requests/review', \Inttegro\UploadRequest\UploadRequest::class, 'upload_request', $payload, $this->headers($options));
    }

    /**
     * Fulfills the upload request with the supplied file.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @return \Inttegro\Shared\UploadFulfillment The resulting upload fulfillment.
     */
    public function fulfill(array $payload): \Inttegro\Shared\UploadFulfillment
    {
        return $this->http->postMultipartValue(
            $payload['upload_url'],
            \Inttegro\Shared\UploadFulfillment::class,
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
