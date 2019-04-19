<?php

namespace App\Events;

use App\Driver;
use App\DriverLocation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class LiveLocationByDriver implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $driver_id;
    public $driver_name;
    public $latitude;
    public $longitude;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(DriverLocation $driver_location)
    {
        $driver = Driver::find($driver_location->driver_id);
        $this->driver_id    = $driver_location->driver_id;
        $this->driver_name = $driver->fname;
        $this->latitude     = $driver_location->latitude;
        $this->longitude    = $driver_location->longitude;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['location-changed'];
       // return new PrivateChannel('channel-name');
    }
}
