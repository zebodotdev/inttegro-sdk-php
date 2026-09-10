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
        return $this->http->postResource('/balances', \Inttegro\BalanceSnapshot::class, 'balances', []);
    }
}
