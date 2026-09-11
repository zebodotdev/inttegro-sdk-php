<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;

/**
 * * Products resource for managing catalog products.
 *
 * Request arrays use the API's documented `snake_case` field names. Successful responses
 * are returned as immutable values from the corresponding singular resource namespace.
 */
class Products
{
    private HttpClient $http;

    /**
     * Creates the products resource client.
     *
     * @param HttpClient $http Shared authenticated HTTP transport used by this resource client.
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Create a product (POST /products/create).
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @return \Inttegro\Product\Product The created product.
     */
    public function create(array $payload): \Inttegro\Product\Product
    {
        return $this->http->postResource('/products/create', \Inttegro\Product\Product::class, 'product', $payload);
    }

    /**
     * Add a price to a product (POST /products/add_price).
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @return \Inttegro\Price\Price The resulting price.
     */
    public function addPrice(array $payload): \Inttegro\Price\Price
    {
        return $this->http->postResource('/products/add_price', \Inttegro\Price\Price::class, 'price', $payload);
    }

    /**
     * Set a product's default unit price (POST /products/set_default_unit_price).
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @return \Inttegro\Product\Product The resulting product.
     */
    public function setDefaultUnitPrice(array $payload): \Inttegro\Product\Product
    {
        return $this->http->postResource('/products/set_default_unit_price', \Inttegro\Product\Product::class, 'product', $payload);
    }

    /**
     * Lookup a product by ID (POST /products/lookup).
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param string $productId Unique identifier of the product.
     * @return \Inttegro\Product\Product The requested product.
     */
    public function lookup(string $productId): \Inttegro\Product\Product
    {
        return $this->http->postResource('/products/lookup', \Inttegro\Product\Product::class, 'product', ['product_id' => $productId]);
    }

    /**
     * Update a product (POST /products/update).
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @return \Inttegro\Product\Product The updated product.
     */
    public function update(array $payload): \Inttegro\Product\Product
    {
        return $this->http->postResource('/products/update', \Inttegro\Product\Product::class, 'product', $payload);
    }

    /**
     * Publish a product (POST /products/publish).
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param string $productId Unique identifier of the product.
     * @return \Inttegro\Product\Product The resulting product.
     */
    public function publish(string $productId): \Inttegro\Product\Product
    {
        return $this->http->postResource('/products/publish', \Inttegro\Product\Product::class, 'product', ['product_id' => $productId]);
    }

    /**
     * Unpublish a product (POST /products/unpublish).
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param string $productId Unique identifier of the product.
     * @return \Inttegro\Product\Product The resulting product.
     */
    public function unpublish(string $productId): \Inttegro\Product\Product
    {
        return $this->http->postResource('/products/unpublish', \Inttegro\Product\Product::class, 'product', ['product_id' => $productId]);
    }

    /**
     * Archive a product (POST /products/archive).
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param string $productId Unique identifier of the product.
     * @return \Inttegro\Product\Product The archived product.
     */
    public function archive(string $productId): \Inttegro\Product\Product
    {
        return $this->http->postResource('/products/archive', \Inttegro\Product\Product::class, 'product', ['product_id' => $productId]);
    }

    /**
     * Page through products (POST /products/page).
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @return \Inttegro\Product\Page A typed page of matching products.
     */
    public function page(array $payload = []): \Inttegro\Product\Page
    {
        return $this->http->postResource('/products/page', \Inttegro\Product\Page::class, 'page', $payload);
    }
}
