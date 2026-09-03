<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;

/**
 * Schedules resource for looking up and canceling scheduled chimes.
 */
class Schedules
{
    private HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Lookup a scheduled chime by schedule ID.
     */
    public function lookup(string $scheduleId): \Inttegro\ScheduleDetail
    {
        return $this->http->postResource('/schedules/lookup', \Inttegro\ScheduleDetail::class, 'scheduled_chime', ['schedule_id' => $scheduleId]);
    }

    /**
     * Cancel a scheduled chime by schedule ID.
     */
    public function cancel(string $scheduleId): \Inttegro\ScheduleCancelDetail
    {
        return $this->http->postResource('/schedules/cancel', \Inttegro\ScheduleCancelDetail::class, 'scheduled_chime', ['schedule_id' => $scheduleId]);
    }
}
