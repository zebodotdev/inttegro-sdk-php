<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;

class Keys
{
    public function __construct(private HttpClient $http)
    {
    }

    public function generate(array $payload = []): \Inttegro\GeneratedSecretKey
    {
        return $this->http->postResource('/keys/generate', \Inttegro\GeneratedSecretKey::class, 'key', $payload);
    }

    public function page(array $payload = []): \Inttegro\SecretKeyPage
    {
        return $this->http->postResource('/keys/page', \Inttegro\SecretKeyPage::class, 'page', $payload);
    }

    public function lookup(string $secretKeyId): \Inttegro\SecretKey
    {
        return $this->http->postResource('/keys/lookup', \Inttegro\SecretKey::class, 'key', ['secret_key_id' => $secretKeyId]);
    }

    public function update(array $payload): \Inttegro\SecretKey
    {
        return $this->http->postResource('/keys/update', \Inttegro\SecretKey::class, 'key', $payload);
    }

    public function destroy(string|array $key): \Inttegro\SecretKey
    {
        return $this->http->postResource('/keys/destroy', \Inttegro\SecretKey::class, 'key', $this->identifierPayload($key));
    }

    public function usage(string|array $key): \Inttegro\SecretKeyUsage
    {
        return $this->http->postValue('/keys/usage', \Inttegro\SecretKeyUsage::class, $this->identifierPayload($key));
    }

    private function identifierPayload(string|array $key): array
    {
        return is_array($key) ? $key : ['secret_key_id' => $key];
    }
}
