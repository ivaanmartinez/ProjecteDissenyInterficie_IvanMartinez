<?php

namespace App\Listeners;

use App\Events\VideoCreated;
use App\Models\User;
use App\Notifications\VideoCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Mockery\Matcher\Not;
use PHPUnit\Framework\TestStatus\Notice;

class SendVideoCreatedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(VideoCreated $event)
    {
        $admins = User::where('super_admin', true)->get();

        // Send the notification to all super admins
        Notification::send($admins, new VideoCreatedNotification($event->video));
    }
}
