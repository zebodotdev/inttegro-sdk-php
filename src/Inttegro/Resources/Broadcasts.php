<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;

/**
 * * Broadcasts resource for looking up and canceling broadcasts.
 *
 * Request arrays use the API's documented `snake_case` field names. Successful responses
 * are returned as immutable values from the corresponding singular resource namespace.
 */
class Broadcasts
{
    private HttpClient $http;

    /**
     * Creates the broadcasts resource client.
     *
     * @param HttpClient $http Shared authenticated HTTP transport used by this resource client.
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Lookup a broadcast by broadcast ID.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param string $broadcastId Unique identifier of the broadcast.
     * @return \Inttegro\Broadcast\Broadcast The requested broadcast.
     */
    public function lookup(string $broadcastId): \Inttegro\Broadcast\Broadcast
    {
        return $this->http->postResource('/broadcasts/lookup', \Inttegro\Broadcast\Broadcast::class, 'broadcast', ['broadcast_id' => $broadcastId]);
    }

    /**
     * Cancel a broadcast by broadcast ID.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param string $broadcastId Unique identifier of the broadcast.
     * @return \Inttegro\Broadcast\CancelDetail The canceled cancel detail.
     */
    public function cancel(string $broadcastId): \Inttegro\Broadcast\CancelDetail
    {
        return $this->http->postResource('/broadcasts/cancel', \Inttegro\Broadcast\CancelDetail::class, 'broadcast', ['broadcast_id' => $broadcastId]);
    }
}
