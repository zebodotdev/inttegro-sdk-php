<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;

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
    public function create(array $payload): \Inttegro\Price
    {
        return $this->http->postResource('/prices/create', \Inttegro\Price::class, 'price', $payload);
    }

    /** Lookup a price by ID (POST /prices/lookup). */
    public function lookup(string $priceId): \Inttegro\Price
    {
        return $this->http->postResource('/prices/lookup', \Inttegro\Price::class, 'price', ['price_id' => $priceId]);
    }

    /** Page through prices (POST /prices/page). */
    public function page(array $payload = []): \Inttegro\PricePage
    {
        return $this->http->postResource('/prices/page', \Inttegro\PricePage::class, 'page', $payload);
    }

    /** Update a price (POST /prices/update). */
    public function update(array $payload): \Inttegro\Price
    {
        return $this->http->postResource('/prices/update', \Inttegro\Price::class, 'price', $payload);
    }

    /** Activate a price (POST /prices/activate). */
    public function activate(string $priceId): \Inttegro\Price
    {
        return $this->http->postResource('/prices/activate', \Inttegro\Price::class, 'price', ['price_id' => $priceId]);
    }

    /** Deactivate a price (POST /prices/deactivate). */
    public function deactivate(string $priceId): \Inttegro\Price
    {
        return $this->http->postResource('/prices/deactivate', \Inttegro\Price::class, 'price', ['price_id' => $priceId]);
    }

    /** Archive a price and mark it inactive (POST /prices/archive). */
    public function archive(string $priceId, ?string $idempotencyKey = null): \Inttegro\Price
    {
        $headers = $idempotencyKey ? ['Idempotency-Key' => $idempotencyKey] : [];
        return $this->http->postResource('/prices/archive', \Inttegro\Price::class, 'price', ['price_id' => $priceId], $headers);
    }
}
