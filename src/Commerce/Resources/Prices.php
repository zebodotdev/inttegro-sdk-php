<?php

namespace Commerce\Resources;

use Commerce\HttpClient;

/**
 * Prices resource for managing catalog prices.
 */
class Prices
{
    private HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /** Create a price (POST /prices/create). */
    public function create(array $payload): \Commerce\ResponseObject
    {
        return $this->http->post('/prices/create', $payload);
    }

    /** Lookup a price by ID (POST /prices/lookup). */
    public function lookup(string $priceId): \Commerce\ResponseObject
    {
        return $this->http->post('/prices/lookup', ['price_id' => $priceId]);
    }

    /** Update a price (POST /prices/update). */
    public function update(array $payload): \Commerce\ResponseObject
    {
        return $this->http->post('/prices/update', $payload);
    }
}
