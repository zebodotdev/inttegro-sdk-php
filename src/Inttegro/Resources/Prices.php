<?php

namespace Inttegro\Resources;

use Inttegro\Price\Price;
use Inttegro\Price\Params;
use Inttegro\HttpClient;

/**
 * * Prices resource for managing catalog prices.
 *
 * Request arrays use the API's documented `snake_case` field names. Successful responses
 * are returned as immutable values from the corresponding singular resource namespace.
 */
class Prices
{
    private HttpClient $http;

    /**
     * Creates the prices resource client.
     *
     * @param HttpClient $http Shared authenticated HTTP transport used by this resource client.
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Create a price (POST /prices/create).
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed>|Params $payload Request fields keyed by the documented `snake_case` API names.
     * @return Price The created price.
     */
    public function create(array|Params $payload): Price
    {
        return $this->http->postResource(
            '/prices/create',
            Price::class,
            'price',
            $payload instanceof Params ? $payload->toArray() : $payload,
        );
    }

    /**
     * Lookup a price by ID (POST /prices/lookup).
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param string $priceId Unique identifier of the price.
     * @return Price The requested price.
     */
    public function lookup(string $priceId): Price
    {
        return $this->http->postResource('/prices/lookup', Price::class, 'price', ['price_id' => $priceId]);
    }

    /**
     * Page through prices (POST /prices/page).
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @return \Inttegro\Price\Page A typed page of matching prices.
     */
    public function page(array $payload = []): \Inttegro\Price\Page
    {
        return $this->http->postResource('/prices/page', \Inttegro\Price\Page::class, 'page', $payload);
    }

    /**
     * Update a price (POST /prices/update).
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @return Price The updated price.
     */
    public function update(array $payload): Price
    {
        return $this->http->postResource('/prices/update', Price::class, 'price', $payload);
    }

    /**
     * Activate a price (POST /prices/activate).
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param string $priceId Unique identifier of the price.
     * @return Price The activated price.
     */
    public function activate(string $priceId): Price
    {
        return $this->http->postResource('/prices/activate', Price::class, 'price', ['price_id' => $priceId]);
    }

    /**
     * Deactivate a price (POST /prices/deactivate).
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param string $priceId Unique identifier of the price.
     * @return Price The deactivated price.
     */
    public function deactivate(string $priceId): Price
    {
        return $this->http->postResource('/prices/deactivate', Price::class, 'price', ['price_id' => $priceId]);
    }

    /**
     * Archive a price and mark it inactive (POST /prices/archive).
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param string $priceId Unique identifier of the price.
     * @param ?string $idempotencyKey Optional idempotency key for safely retrying the same logical write.
     * @return Price The archived price.
     */
    public function archive(string $priceId, ?string $idempotencyKey = null): Price
    {
        $headers = $idempotencyKey ? ['Idempotency-Key' => $idempotencyKey] : [];
        return $this->http->postResource('/prices/archive', Price::class, 'price', ['price_id' => $priceId], $headers);
    }
}
