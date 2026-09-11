<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;

/**
 * Application creation, lookup, and update operations.
 *
 * Request arrays use the API's documented `snake_case` field names. Successful responses
 * are returned as immutable values from the corresponding singular resource namespace.
 */
class Apps
{
    private HttpClient $http;

    /**
     * Creates the apps resource client.
     *
     * @param HttpClient $http Shared authenticated HTTP transport used by this resource client.
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Creates a new application.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @return \Inttegro\App\App The created app.
     */
    public function create(array $payload): \Inttegro\App\App
    {
        return $this->http->postResource('/apps/create', \Inttegro\App\App::class, 'app', $payload);
    }

    /**
     * Retrieves the requested application.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @return \Inttegro\App\App The requested app.
     */
    public function lookup(): \Inttegro\App\App
    {
        return $this->http->postResource('/apps/lookup', \Inttegro\App\App::class, 'app', []);
    }

    /**
     * Updates the supplied fields on the application.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @return \Inttegro\App\App The updated app.
     */
    public function update(array $payload): \Inttegro\App\App
    {
        return $this->http->postResource('/apps/update', \Inttegro\App\App::class, 'app', $payload);
    }
}
