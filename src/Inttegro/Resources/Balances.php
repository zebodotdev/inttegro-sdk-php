<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;

/**
 * Client operations for Inttegro balances.
 *
 * Request arrays use the API's documented `snake_case` field names. Responses
 * are returned as immutable values from the corresponding singular namespace.
 */
class Balances
{
    private HttpClient $http;

    /**
     * Creates the balances resource client.
     *
     * @param HttpClient $http Shared authenticated HTTP transport used by this resource client.
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Retrieves the current balance.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @return \Inttegro\Balance\Balance The resulting balance.
     */
    public function get(): \Inttegro\Balance\Balance
    {
        return $this->http->postResource('/balances', \Inttegro\Balance\Balance::class, 'balances', []);
    }
}
