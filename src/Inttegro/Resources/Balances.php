<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;

class Balances
{
    private HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    public function get(): \Inttegro\BalanceSnapshot
    {
        return $this->http->postValue('/balances', \Inttegro\BalanceSnapshot::class, []);
    }
}
