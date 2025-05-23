<?php

namespace App\Notifications;

use App\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class VideoCreatedNotification extends Notification
{
    use Queueable;

    public $video;

    /**
     * Crear una nueva instancia de la notificación.
     *
     * @param Video $video
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * Los canales a través de los cuales debe enviarse la notificación.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'broadcast']; // Los canales para enviar la notificación
    }

    /**
     * Enviar la notificación por correo.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nuevo Video Creado')
            ->line('Un nuevo video ha sido creado.')
            ->line('Título del Video: ' . $this->video->title)
            ->line('URL del Video: ' . $this->video->url)
            ->action('Ver Video', url($this->video->url))
            ->line('Gracias por usar nuestra aplicación.');
    }

    /**
     * Guardar la notificación en la base de datos.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'video_id' => $this->video->id,
            'title' => $this->video->title,
            'description' => $this->video->description,
        ];
    }

    /**
     * Enviar la notificación por broadcast (Pusher).
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'video_id' => $this->video->id,
            'title' => $this->video->title,
            'description' => $this->video->description,
        ]);
    }
}
