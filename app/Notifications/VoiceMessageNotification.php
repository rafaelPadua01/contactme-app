<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class VoiceMessageNotification extends Notification
{
    use Queueable;
    private $voice_messages;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($voice_messages)
    {
        //
        $this->voice_messages = $voice_messages;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function toBroadcast($notifiable){ 
        return new BroadcastMessage([
            'chat_id' => $this->voice_messages->id,
            'sender_id' => $this->voice_messages->send_id,
            'receiver_id' => $this->voice_messages->receiver_id,
            'message' => $this->voice_messages->audio_name, 
        ]);
    }
}
