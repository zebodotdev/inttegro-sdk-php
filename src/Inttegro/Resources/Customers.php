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
    public function create(array $payload): \Inttegro\Customer
    {
        return $this->http->postResource('/customers/create', \Inttegro\Customer::class, 'customer', $payload);
    }

    /** Lookup a customer by ID (POST /customers/lookup). */
    public function lookup(string $customerId): \Inttegro\Customer
    {
        return $this->http->postResource('/customers/lookup', \Inttegro\Customer::class, 'customer', ['customer_id' => $customerId]);
    }

    /** Update supplied fields on a customer record (POST /customers/update). */
    public function update(array $payload, ?string $idempotencyKey = null): \Inttegro\Customer
    {
        $headers = $idempotencyKey ? ['Idempotency-Key' => $idempotencyKey] : [];
        return $this->http->postResource('/customers/update', \Inttegro\Customer::class, 'customer', $payload, $headers);
    }

    /** Page through customers (POST /customers/page). */
    public function page(array $payload = []): \Inttegro\CustomerPage
    {
        return $this->http->postResource('/customers/page', \Inttegro\CustomerPage::class, 'page', $payload);
    }
}
