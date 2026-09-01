<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;
use Inttegro\ResponseObject;

class Balances
{
    private HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    public function get(): ResponseObject
    {
        return $this->http->post('/balances', []);
    }
}
