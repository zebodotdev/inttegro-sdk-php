<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;
use Inttegro\ResponseObject;

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
