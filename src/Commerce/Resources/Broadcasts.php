<?php

namespace Commerce\Resources;

use Commerce\HttpClient;

/**
 * Broadcasts resource for looking up and canceling broadcasts.
 */
class Broadcasts
{
    private HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Lookup a broadcast by broadcast ID.
     */
    public function lookup(string $broadcastId): \Commerce\ResponseObject
    {
        return $this->http->post('/broadcasts/lookup', ['broadcast_id' => $broadcastId]);
    }

    /**
     * Cancel a broadcast by broadcast ID.
     */
    public function cancel(string $broadcastId): \Commerce\ResponseObject
    {
        return $this->http->post('/broadcasts/cancel', ['broadcast_id' => $broadcastId]);
    }
}
