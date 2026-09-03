<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;

class PurchaseIntents
{
    public function __construct(private HttpClient $http)
    {
    }

    public function create(array $payload): \Inttegro\PurchaseIntent
    {
        return $this->http->postResource('/purchase_intents/create', \Inttegro\PurchaseIntent::class, 'purchase_intent', $payload);
    }

    public function update(array $payload): \Inttegro\PurchaseIntent
    {
        return $this->http->postResource('/purchase_intents/update', \Inttegro\PurchaseIntent::class, 'purchase_intent', $payload);
    }

    public function cancel(string $id): \Inttegro\PurchaseIntent
    {
        return $this->http->postResource('/purchase_intents/cancel', \Inttegro\PurchaseIntent::class, 'purchase_intent', ['id' => $id]);
    }

    public function lookup(string $id): \Inttegro\PurchaseIntent
    {
        return $this->http->postResource('/purchase_intents/lookup', \Inttegro\PurchaseIntent::class, 'purchase_intent', ['id' => $id]);
    }

    public function page(array $payload = []): \Inttegro\PurchaseIntentPage
    {
        return $this->http->postResource('/purchase_intents/page', \Inttegro\PurchaseIntentPage::class, 'page', $payload);
    }
}
