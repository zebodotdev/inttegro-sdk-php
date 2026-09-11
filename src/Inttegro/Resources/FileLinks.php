<?php

namespace Inttegro\Resources;

use Inttegro\FileDownload;
use Inttegro\HttpClient;

/**
 * Client operations for Inttegro file links.
 *
 * Request arrays use the API's documented `snake_case` field names. Responses
 * are returned as immutable values from the corresponding singular namespace.
 */
class FileLinks
{
    /**
     * Creates the file links resource client.
     *
     * @param HttpClient $http Shared authenticated HTTP transport used by this resource client.
     */
    public function __construct(private HttpClient $http)
    {
    }

    /**
     * Creates a new file link.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @param array<string, mixed> $options Optional endpoint-specific request fields.
     * @return \Inttegro\FileLink\Creation The created creation.
     */
    public function create(array $payload, array $options = []): \Inttegro\FileLink\Creation
    {
        return $this->http->postValue('/file_links/create', \Inttegro\FileLink\Creation::class, $payload, $this->headers($options));
    }

    /**
     * Retrieves the requested file link.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param string $id ID value.
     * @return \Inttegro\FileLink\FileLink The requested file link.
     */
    public function lookup(string $id): \Inttegro\FileLink\FileLink
    {
        return $this->http->postResource('/file_links/lookup', \Inttegro\FileLink\FileLink::class, 'file_link', ['id' => $id]);
    }

    /**
     * Retrieves a paginated collection of file links.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @return \Inttegro\FileLink\Page A typed page of matching file links.
     */
    public function page(array $payload = []): \Inttegro\FileLink\Page
    {
        return $this->http->postResource('/file_links/page', \Inttegro\FileLink\Page::class, 'page', $payload);
    }

    /**
     * Performs the `revoke` operation for the file link.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @param array<string, mixed> $options Optional endpoint-specific request fields.
     * @return \Inttegro\FileLink\FileLink The resulting file link.
     */
    public function revoke(array $payload, array $options = []): \Inttegro\FileLink\FileLink
    {
        return $this->http->postResource('/file_links/revoke', \Inttegro\FileLink\FileLink::class, 'file_link', $payload, $this->headers($options));
    }

    /**
     * Performs the `open` operation for the file link.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param string $url URL value.
     * @param ?string $saveTo save To value.
     * @return FileDownload The resulting file download.
     */
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
