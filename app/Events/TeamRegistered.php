<?php

namespace App\Events;

use App\Models\EventRegistration;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TeamRegistered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The EventRegistration instance.
     *
     * @var \App\Models\EventRegistration
     */
    public $eventRegistration;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(EventRegistration $eventRegistration)
    {
        $this->eventRegistration = $eventRegistration;
    }
}
