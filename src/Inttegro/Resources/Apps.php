<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;

/** Application creation, lookup, and update operations. */
class Apps
{
    private HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    public function create(array $payload): \Inttegro\Application
    {
        return $this->http->postResource('/apps/create', \Inttegro\Application::class, 'app', $payload);
    }

    public function lookup(): \Inttegro\Application
    {
        return $this->http->postResource('/apps/lookup', \Inttegro\Application::class, 'app', []);
    }

    public function update(array $payload): \Inttegro\Application
    {
        return $this->http->postResource('/apps/update', \Inttegro\Application::class, 'app', $payload);
    }
}
