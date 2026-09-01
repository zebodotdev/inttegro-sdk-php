<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;

/**
 * Products resource for managing catalog products.
 */
class Products
{
    private HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /** Create a product (POST /products/create). */
    public function create(array $payload): \Inttegro\ResponseObject
    {
        return $this->http->post('/products/create', $payload);
    }

    /** Add a price to a product (POST /products/add_price). */
    public function addPrice(array $payload): \Inttegro\ResponseObject
    {
        return $this->http->post('/products/add_price', $payload);
    }

    /** Set a product's default unit price (POST /products/set_default_unit_price). */
    public function setDefaultUnitPrice(array $payload): \Inttegro\ResponseObject
    {
        return $this->http->post('/products/set_default_unit_price', $payload);
    }

    /** Lookup a product by ID (POST /products/lookup). */
    public function lookup(string $productId): \Inttegro\ResponseObject
    {
        return $this->http->post('/products/lookup', ['product_id' => $productId]);
    }

    /** Update a product (POST /products/update). */
    public function update(array $payload): \Inttegro\ResponseObject
    {
        return $this->http->post('/products/update', $payload);
    }

    /** Publish a product (POST /products/publish). */
    public function publish(string $productId): \Inttegro\ResponseObject
    {
        return $this->http->post('/products/publish', ['product_id' => $productId]);
    }

    /** Unpublish a product (POST /products/unpublish). */
    public function unpublish(string $productId): \Inttegro\ResponseObject
    {
        return $this->http->post('/products/unpublish', ['product_id' => $productId]);
    }

    /** Archive a product (POST /products/archive). */
    public function archive(string $productId): \Inttegro\ResponseObject
    {
        return $this->http->post('/products/archive', ['product_id' => $productId]);
    }

    /** Page through products (POST /products/page). */
    public function page(array $payload = []): \Inttegro\ResponseObject
    {
        return $this->http->post('/products/page', $payload);
    }
}
