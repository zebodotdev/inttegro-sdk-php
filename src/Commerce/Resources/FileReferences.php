<?php

namespace Commerce\Resources;

use Commerce\HttpClient;
use Commerce\ResponseObject;

class FileReferences
{
    public function __construct(private HttpClient $http)
    {
    }

    public function reconcile(array $payload): ResponseObject
    {
        return $this->http->post('/file_references/reconcile', $payload);
    }
}
