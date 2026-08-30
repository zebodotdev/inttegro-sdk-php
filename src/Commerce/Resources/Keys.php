<?php

namespace Commerce\Resources;

use Commerce\HttpClient;
use Commerce\ResponseObject;

class Keys
{
    public function __construct(private HttpClient $http)
    {
    }

    public function generate(array $payload = []): ResponseObject
    {
        return $this->http->post('/keys/generate', $payload);
    }

    public function page(array $payload = []): ResponseObject
    {
        return $this->http->post('/keys/page', $payload);
    }

    public function lookup(string $secretKeyId): ResponseObject
    {
        return $this->http->post('/keys/lookup', ['secret_key_id' => $secretKeyId]);
    }

    public function update(array $payload): ResponseObject
    {
        return $this->http->post('/keys/update', $payload);
    }

    public function destroy(string|array $key): ResponseObject
    {
        return $this->http->post('/keys/destroy', $this->identifierPayload($key));
    }

    public function usage(string|array $key): ResponseObject
    {
        return $this->http->post('/keys/usage', $this->identifierPayload($key));
    }

    private function identifierPayload(string|array $key): array
    {
        return is_array($key) ? $key : ['secret_key_id' => $key];
    }
}
