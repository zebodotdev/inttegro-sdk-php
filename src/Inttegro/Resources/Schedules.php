<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;

/**
 * * Schedules resource for looking up and canceling scheduled chimes.
 *
 * Request arrays use the API's documented `snake_case` field names. Successful responses
 * are returned as immutable values from the corresponding singular resource namespace.
 */
class Schedules
{
    private HttpClient $http;

    /**
     * Creates the schedules resource client.
     *
     * @param HttpClient $http Shared authenticated HTTP transport used by this resource client.
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Lookup a scheduled chime by schedule ID.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param string $scheduleId Unique identifier of the schedule.
     * @return \Inttegro\Schedule\Schedule The requested schedule.
     */
    public function lookup(string $scheduleId): \Inttegro\Schedule\Schedule
    {
        return $this->http->postResource('/schedules/lookup', \Inttegro\Schedule\Schedule::class, 'scheduled_chime', ['schedule_id' => $scheduleId]);
    }

    /**
     * Cancel a scheduled chime by schedule ID.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param string $scheduleId Unique identifier of the schedule.
     * @return \Inttegro\Schedule\CancelDetail The canceled cancel detail.
     */
    public function cancel(string $scheduleId): \Inttegro\Schedule\CancelDetail
    {
        return $this->http->postResource('/schedules/cancel', \Inttegro\Schedule\CancelDetail::class, 'scheduled_chime', ['schedule_id' => $scheduleId]);
    }
}
