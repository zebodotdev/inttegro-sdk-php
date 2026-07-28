<?php

namespace Commerce\Resources;

use Commerce\HttpClient;

/** Application creation, lookup, and update operations. */
class Apps
{
    private HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    public function create(array $payload): \Commerce\ResponseObject
    {
        return $this->http->post('/apps/create', $payload);
    }

    public function lookup(): \Commerce\ResponseObject
    {
        return $this->http->post('/apps/lookup', []);
    }

    public function update(array $payload): \Commerce\ResponseObject
    {
        return $this->http->post('/apps/update', $payload);
    }
}
