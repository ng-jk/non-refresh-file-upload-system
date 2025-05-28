<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class fileEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $status;
    public $fileName;

    /**
     * Create a new event instance.
     */
    public function __construct($status, $fileName)
    {
        $this->status = $status;
        $this->fileName = $fileName;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */

     public function broadcastWith()
    {
        info('broadcast successfully');
        return [
            'status' => $this->status,
            'fileName' => $this->fileName,
        ];
    }
    public function broadcastOn(): Array
    {
        return [
            new Channel('statusChannel'),
        ];
    }
}
