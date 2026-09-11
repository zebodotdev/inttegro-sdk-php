<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;

/**
 * Client operations for Inttegro keys.
 *
 * Request arrays use the API's documented `snake_case` field names. Responses
 * are returned as immutable values from the corresponding singular namespace.
 */
class Keys
{
    /**
     * Creates the keys resource client.
     *
     * @param HttpClient $http Shared authenticated HTTP transport used by this resource client.
     */
    public function __construct(private HttpClient $http)
    {
    }

    /**
     * Generates a new secret key.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @return \Inttegro\SecretKey\Generated The resulting generated.
     */
    public function generate(array $payload = []): \Inttegro\SecretKey\Generated
    {
        return $this->http->postResource('/keys/generate', \Inttegro\SecretKey\Generated::class, 'key', $payload);
    }

    /**
     * Retrieves a paginated collection of keys.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @return \Inttegro\SecretKey\Page A typed page of matching keys.
     */
    public function page(array $payload = []): \Inttegro\SecretKey\Page
    {
        return $this->http->postResource('/keys/page', \Inttegro\SecretKey\Page::class, 'page', $payload);
    }

    /**
     * Retrieves the requested secret key.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param string $secretKeyId Unique identifier of the secret key.
     * @return \Inttegro\SecretKey\SecretKey The requested secret key.
     */
    public function lookup(string $secretKeyId): \Inttegro\SecretKey\SecretKey
    {
        return $this->http->postResource('/keys/lookup', \Inttegro\SecretKey\SecretKey::class, 'key', ['secret_key_id' => $secretKeyId]);
    }

    /**
     * Updates the supplied fields on the secret key.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @return \Inttegro\SecretKey\SecretKey The updated secret key.
     */
    public function update(array $payload): \Inttegro\SecretKey\SecretKey
    {
        return $this->http->postResource('/keys/update', \Inttegro\SecretKey\SecretKey::class, 'key', $payload);
    }

    /**
     * Destroys the secret key.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param string|array $key key value.
     * @return \Inttegro\SecretKey\SecretKey The destroyed secret key result.
     */
    public function destroy(string|array $key): \Inttegro\SecretKey\SecretKey
    {
        return $this->http->postResource('/keys/destroy', \Inttegro\SecretKey\SecretKey::class, 'key', $this->identifierPayload($key));
    }

    /**
     * Retrieves usage records for a secret key.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param string|array $key key value.
     * @return \Inttegro\SecretKey\Usage The resulting usage.
     */
    public function usage(string|array $key): \Inttegro\SecretKey\Usage
    {
        return $this->http->postValue('/keys/usage', \Inttegro\SecretKey\Usage::class, $this->identifierPayload($key));
    }

    private function identifierPayload(string|array $key): array
    {
        return is_array($key) ? $key : ['secret_key_id' => $key];
    }
}
