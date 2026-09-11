<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;

/**
 * * Customers resource for managing customer records.
 *
 * Request arrays use the API's documented `snake_case` field names. Successful responses
 * are returned as immutable values from the corresponding singular resource namespace.
 */
class Customers
{
    private HttpClient $http;

    /**
     * Creates the customers resource client.
     *
     * @param HttpClient $http Shared authenticated HTTP transport used by this resource client.
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Create a customer (POST /customers/create).
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @return \Inttegro\Customer\Customer The created customer.
     */
    public function create(array $payload): \Inttegro\Customer\Customer
    {
        return $this->http->postResource('/customers/create', \Inttegro\Customer\Customer::class, 'customer', $payload);
    }

    /**
     * Lookup a customer by ID (POST /customers/lookup).
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param string $customerId Unique identifier of the customer.
     * @return \Inttegro\Customer\Customer The requested customer.
     */
    public function lookup(string $customerId): \Inttegro\Customer\Customer
    {
        return $this->http->postResource('/customers/lookup', \Inttegro\Customer\Customer::class, 'customer', ['customer_id' => $customerId]);
    }

    /**
     * Update supplied fields on a customer record (POST /customers/update).
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @param ?string $idempotencyKey Optional idempotency key for safely retrying the same logical write.
     * @return \Inttegro\Customer\Customer The updated customer.
     */
    public function update(array $payload, ?string $idempotencyKey = null): \Inttegro\Customer\Customer
    {
        $headers = $idempotencyKey ? ['Idempotency-Key' => $idempotencyKey] : [];
        return $this->http->postResource('/customers/update', \Inttegro\Customer\Customer::class, 'customer', $payload, $headers);
    }

    /**
     * Page through customers (POST /customers/page).
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @return \Inttegro\Customer\Page A typed page of matching customers.
     */
    public function page(array $payload = []): \Inttegro\Customer\Page
    {
        return $this->http->postResource('/customers/page', \Inttegro\Customer\Page::class, 'page', $payload);
    }
}
