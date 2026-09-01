<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;

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
    public function create(array $payload): \Inttegro\ResponseObject
    {
        return $this->http->post('/customers/create', $payload);
    }

    /** Lookup a customer by ID (POST /customers/lookup). */
    public function lookup(string $customerId): \Inttegro\ResponseObject
    {
        return $this->http->post('/customers/lookup', ['customer_id' => $customerId]);
    }

    /** Page through customers (POST /customers/page). */
    public function page(array $payload = []): \Inttegro\ResponseObject
    {
        return $this->http->post('/customers/page', $payload);
    }
}
