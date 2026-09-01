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

    public function create(array $payload): \Inttegro\ResponseObject
    {
        return $this->http->post('/apps/create', $payload);
    }

    public function lookup(): \Inttegro\ResponseObject
    {
        return $this->http->post('/apps/lookup', []);
    }

    public function update(array $payload): \Inttegro\ResponseObject
    {
        return $this->http->post('/apps/update', $payload);
    }
}
