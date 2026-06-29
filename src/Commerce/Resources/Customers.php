<?php

namespace Commerce\Resources;

use Commerce\HttpClient;

/**
 * Customers resource for managing customer records.
 */
class Customers
{
    private HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /** Create a customer (POST /customers/create). */
    public function create(array $payload): \Commerce\ResponseObject
    {
        return $this->http->post('/customers/create', $payload);
    }

    /** Lookup a customer by ID (POST /customers/lookup). */
    public function lookup(string $customerId): \Commerce\ResponseObject
    {
        return $this->http->post('/customers/lookup', ['customer_id' => $customerId]);
    }

    /** Page through customers (POST /customers/page). */
    public function page(array $payload = []): \Commerce\ResponseObject
    {
        return $this->http->post('/customers/page', $payload);
    }
}
