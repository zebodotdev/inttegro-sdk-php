<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;

/**
 * Client operations for Inttegro file references.
 *
 * Request arrays use the API's documented `snake_case` field names. Responses
 * are returned as immutable values from the corresponding singular namespace.
 */
class FileReferences
{
    /**
     * Creates the file references resource client.
     *
     * @param HttpClient $http Shared authenticated HTTP transport used by this resource client.
     */
    public function __construct(private HttpClient $http)
    {
    }

    /**
     * Reconciles file references against their current API state.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @return \Inttegro\FileReference\Reconciliation The resulting reconciliation.
     */
    public function reconcile(array $payload): \Inttegro\FileReference\Reconciliation
    {
        return $this->http->postValue('/file_references/reconcile', \Inttegro\FileReference\Reconciliation::class, $payload);
    }
}
