<?php

namespace Tests\Feature;

use App\Events\VideoCreated;
use App\Models\User;
use App\Notifications\VideoCreatedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use App\Helpers\DefaultVideoHelper;
class VideoNotificationsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Comprova que l'event VideoCreated es dispara quan es crea un vídeo.
     *
     * @return void
     */
    public function test_video_created_event_is_dispatched()
    {
        // Mock de l'event
        Event::fake();

        // Crear un vídeo per defecte utilitzant el helper
        $video = DefaultVideoHelper::createDefaultVideo();

        // Comprovar que l'event VideoCreated ha estat disparat
        Event::assertDispatched(VideoCreated::class, function ($event) use ($video) {
            return $event->video->id === $video->id;
        });
    }

    /**
     * Comprova que s'envia una notificació push quan es crea un vídeo.
     *
     * @return void
     */
    public function test_push_notification_is_sent_when_video_is_created()
    {
        create_permissions();

        // Mock de la notificació
        Notification::fake();

        // Crear un usuari administrador (suposant que existeix la propietat 'super_admin')
        $admin = User::factory()->create([
            'super_admin' => true
        ]);

        // Crear un vídeo per defecte utilitzant el helper
        $video = DefaultVideoHelper::createDefaultVideo();

        // Disparar l'event VideoCreated
        event(new VideoCreated($video));

        // Comprovar que la notificació VideoCreated ha estat enviada al super_admin
        Notification::assertSentTo(
            $admin,
            VideoCreatedNotification::class,
            function ($notification, $channels) use ($video) {
                // Assegurar-nos que la notificació conté el vídeo correcte
                return $notification->video->id === $video->id;
            }
        );
    }
}
