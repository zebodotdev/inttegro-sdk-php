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
    public function create(array $payload): \Inttegro\Product
    {
        return $this->http->postResource('/products/create', \Inttegro\Product::class, 'product', $payload);
    }

    /** Add a price to a product (POST /products/add_price). */
    public function addPrice(array $payload): \Inttegro\ProductPriceNominal
    {
        return $this->http->postResource('/products/add_price', \Inttegro\ProductPriceNominal::class, 'price', $payload);
    }

    /** Set a product's default unit price (POST /products/set_default_unit_price). */
    public function setDefaultUnitPrice(array $payload): \Inttegro\Product
    {
        return $this->http->postResource('/products/set_default_unit_price', \Inttegro\Product::class, 'product', $payload);
    }

    /** Lookup a product by ID (POST /products/lookup). */
    public function lookup(string $productId): \Inttegro\Product
    {
        return $this->http->postResource('/products/lookup', \Inttegro\Product::class, 'product', ['product_id' => $productId]);
    }

    /** Update a product (POST /products/update). */
    public function update(array $payload): \Inttegro\Product
    {
        return $this->http->postResource('/products/update', \Inttegro\Product::class, 'product', $payload);
    }

    /** Publish a product (POST /products/publish). */
    public function publish(string $productId): \Inttegro\Product
    {
        return $this->http->postResource('/products/publish', \Inttegro\Product::class, 'product', ['product_id' => $productId]);
    }

    /** Unpublish a product (POST /products/unpublish). */
    public function unpublish(string $productId): \Inttegro\Product
    {
        return $this->http->postResource('/products/unpublish', \Inttegro\Product::class, 'product', ['product_id' => $productId]);
    }

    /** Archive a product (POST /products/archive). */
    public function archive(string $productId): \Inttegro\Product
    {
        return $this->http->postResource('/products/archive', \Inttegro\Product::class, 'product', ['product_id' => $productId]);
    }

    /** Page through products (POST /products/page). */
    public function page(array $payload = []): \Inttegro\ProductPage
    {
        return $this->http->postResource('/products/page', \Inttegro\ProductPage::class, 'page', $payload);
    }
}
