<?php

namespace App\Events;

use App\Models\Video;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VideoCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $video;
    /**
     * Create a new event instance.
     */
    public function __construct(Video $video )
    {
        $this->video = $video;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn()
    {
        return new Channel('videos');
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'video.created';
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'video' => $this->video,
            'user' => $this->video->user,
            'created_at' => $this->video->created_at,
            'updated_at' => $this->video->updated_at,
            'id' => $this->video->id,
            'title' => $this->video->title,
            'description' => $this->video->description,
        ];
    }
}
