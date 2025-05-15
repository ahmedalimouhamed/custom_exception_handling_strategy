<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MediableEntityChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Model $model;
    public string $action; //created, updated, deleted

    /**
     * Create a new event instance.
     */
    public function __construct(Model $model, string $action)
    {
        $this->model = $model;
        $this->action = $action;
    }
}
