<?php

namespace Inttegro\Resources;

use Inttegro\FileDownload;
use Inttegro\HttpClient;

/**
 * Client operations for Inttegro files.
 *
 * Request arrays use the API's documented `snake_case` field names. Responses
 * are returned as immutable values from the corresponding singular namespace.
 */
class Files
{
    /**
     * Creates the files resource client.
     *
     * @param HttpClient $http Shared authenticated HTTP transport used by this resource client.
     */
    public function __construct(private HttpClient $http)
    {
    }

    /**
     * Creates a new file.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @param array<string, mixed> $options Optional endpoint-specific request fields.
     * @return \Inttegro\File\File The created file.
     */
    public function create(array $payload, array $options = []): \Inttegro\File\File
    {
        $file = $payload['file'];
        unset($payload['file']);
        $idempotencyKey = $options['idempotency_key'] ?? $payload['idempotency_key'] ?? null;
        unset($payload['idempotency_key']);
        return $this->http->postMultipartResource(
            '/files/create',
            \Inttegro\File\File::class,
            'file',
            $payload,
            ['file' => $file],
            $this->headers($idempotencyKey)
        );
    }

    /**
     * Retrieves the requested file.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param string $fileId Unique identifier of the file.
     * @return \Inttegro\File\File The requested file.
     */
    public function lookup(string $fileId): \Inttegro\File\File
    {
        return $this->http->postResource('/files/lookup', \Inttegro\File\File::class, 'file', ['file_id' => $fileId]);
    }

    /**
     * Retrieves a paginated collection of files.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @return \Inttegro\File\Page A typed page of matching files.
     */
    public function page(array $payload = []): \Inttegro\File\Page
    {
        return $this->http->postResource('/files/page', \Inttegro\File\Page::class, 'page', $payload);
    }

    /**
     * Downloads the contents of the file.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @return FileDownload The downloaded file download.
     */
    public function contents(array $payload): FileDownload
    {
        return $this->http->postBinaryJson('/files/contents', $payload);
    }

    /**
     * Deletes the file.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param string $fileId Unique identifier of the file.
     * @return \Inttegro\File\File The deleted file result.
     */
    public function delete(string $fileId): \Inttegro\File\File
    {
        return $this->http->postResource('/files/delete', \Inttegro\File\File::class, 'file', ['file_id' => $fileId]);
    }

    private function headers(?string $idempotencyKey): array
    {
        return $idempotencyKey !== null ? ['Idempotency-Key' => $idempotencyKey] : [];
    }
}
