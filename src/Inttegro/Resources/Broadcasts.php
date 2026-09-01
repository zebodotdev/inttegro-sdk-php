<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;

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
    public function lookup(string $broadcastId): \Inttegro\ResponseObject
    {
        return $this->http->post('/broadcasts/lookup', ['broadcast_id' => $broadcastId]);
    }

    /**
     * Cancel a broadcast by broadcast ID.
     */
    public function cancel(string $broadcastId): \Inttegro\ResponseObject
    {
        return $this->http->post('/broadcasts/cancel', ['broadcast_id' => $broadcastId]);
    }
}
