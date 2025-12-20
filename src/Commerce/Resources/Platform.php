<?php

namespace Commerce\Resources;

use Commerce\HttpClient;

/**
 * Platform resource for application and session management.
 *
 * Platform operations handle application creation, API key generation, and session
 * initialization. These are administrative functions typically used during application
 * setup and authentication flows.
 *
 * @see https://commerce.zebo.dev/platform for platform guides
 */
class Platform
{
    private HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Create a new Commerce application.
     *
     * Applications are the top-level organizational unit in Commerce. Each application
     * has its own balance, customers, orders, and API keys. Use this to programmatically
     * provision new applications or build multi-tenant platforms.
     *
     * @param array $payload Application creation parameters
     *   - Application-specific configuration (refer to API documentation for details)
     *
     * @return \Commerce\ResponseObject Created application
     *
     * @example Create a new application
     * ```php
     * $result = $client->platform->createApp([
     *     'name' => 'My Commerce App',
     *     'description' => 'Production payment processing'
     * ]);
     *
     * $app = $result->data['application'];
     * echo "Application created: {$app['id']}\n";
     * ```
     *
     * @see https://commerce.zebo.dev/applications for application management
     */
    public function createApp(array $payload): \Commerce\ResponseObject
    {
        return $this->http->post('/apps/create', $payload);
    }

    /**
     * Generate a new API key for an application.
     *
     * Creates an API key for authenticating requests to the Commerce API. Keys can have
     * different permission levels and expiration policies. Store keys securely—they cannot
     * be retrieved after generation.
     *
     * @param array $payload Key generation parameters
     *   - Key configuration including permissions and expiration (refer to API docs)
     *
     * @return \Commerce\ResponseObject Generated API key
     *
     * @example Generate API key
     * ```php
     * $result = $client->platform->generateKey([
     *     'application_id' => 'app_abc123',
     *     'description' => 'Production server key'
     * ]);
     *
     * $key = $result->data['key'];
     * echo "API key generated: {$key['key']}\n";
     * echo "Store this securely—it won't be shown again!\n";
     * ```
     *
     * @see https://commerce.zebo.dev/authentication for API key management
     */
    public function generateKey(array $payload): \Commerce\ResponseObject
    {
        return $this->http->post('/keys/generate', $payload);
    }

    /**
     * Create a new authenticated session.
     *
     * Initializes a session for user authentication flows. Sessions are used to maintain
     * authenticated state in web applications and can be configured with different
     * expiration and security policies.
     *
     * @param array $payload Session creation parameters
     *   - Session configuration (refer to API documentation for details)
     *
     * @return \Commerce\ResponseObject Created session
     *
     * @example Initialize session
     * ```php
     * $result = $client->platform->newSession([
     *     'application_id' => 'app_abc123'
     * ]);
     *
     * $session = $result->data['session'];
     * echo "Session created: {$session['id']}\n";
     * ```
     *
     * @see https://commerce.zebo.dev/sessions for session management
     */
    public function newSession(array $payload): \Commerce\ResponseObject
    {
        return $this->http->post('/sessions/new', $payload);
    }
}
