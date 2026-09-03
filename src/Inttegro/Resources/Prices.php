<?php

namespace Inttegro\Resources;

use Inttegro\CatalogPrice;
use Inttegro\CatalogPriceParams;
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
    public function create(array|CatalogPriceParams $payload): CatalogPrice
    {
        return $this->http->postResource(
            '/prices/create',
            CatalogPrice::class,
            'price',
            $payload instanceof CatalogPriceParams ? $payload->toArray() : $payload,
        );
    }

    /** Lookup a price by ID (POST /prices/lookup). */
    public function lookup(string $priceId): CatalogPrice
    {
        return $this->http->postResource('/prices/lookup', CatalogPrice::class, 'price', ['price_id' => $priceId]);
    }

    /** Page through prices (POST /prices/page). */
    public function page(array $payload = []): \Inttegro\PricePage
    {
        return $this->http->postResource('/prices/page', \Inttegro\PricePage::class, 'page', $payload);
    }

    /** Update a price (POST /prices/update). */
    public function update(array $payload): CatalogPrice
    {
        return $this->http->postResource('/prices/update', CatalogPrice::class, 'price', $payload);
    }

    /** Activate a price (POST /prices/activate). */
    public function activate(string $priceId): CatalogPrice
    {
        return $this->http->postResource('/prices/activate', CatalogPrice::class, 'price', ['price_id' => $priceId]);
    }

    /** Deactivate a price (POST /prices/deactivate). */
    public function deactivate(string $priceId): CatalogPrice
    {
        return $this->http->postResource('/prices/deactivate', CatalogPrice::class, 'price', ['price_id' => $priceId]);
    }

    /** Archive a price and mark it inactive (POST /prices/archive). */
    public function archive(string $priceId, ?string $idempotencyKey = null): CatalogPrice
    {
        $headers = $idempotencyKey ? ['Idempotency-Key' => $idempotencyKey] : [];
        return $this->http->postResource('/prices/archive', CatalogPrice::class, 'price', ['price_id' => $priceId], $headers);
    }
}
