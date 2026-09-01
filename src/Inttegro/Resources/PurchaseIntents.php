<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;
use Inttegro\ResponseObject;

class PurchaseIntents
{
    public function __construct(private HttpClient $http)
    {
    }

    public function create(array $payload): ResponseObject
    {
        return $this->http->post('/purchase_intents/create', $payload);
    }

    public function update(array $payload): ResponseObject
    {
        return $this->http->post('/purchase_intents/update', $payload);
    }

    public function cancel(string $id): ResponseObject
    {
        return $this->http->post('/purchase_intents/cancel', ['id' => $id]);
    }

    public function lookup(string $id): ResponseObject
    {
        return $this->http->post('/purchase_intents/lookup', ['id' => $id]);
    }

    public function page(array $payload = []): ResponseObject
    {
        return $this->http->post('/purchase_intents/page', $payload);
    }
}
