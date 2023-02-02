<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Service;

class TimeRequest extends Notification
{
    use Queueable;
    private $services;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($services)
    {
        //
        $this->services = $services;
        
        
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
       // return ['mail', 'database'];
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
            'client_name' => $this->services->client_name,
            'marked_day' => $this->services->marked_day,
            'marked_hour' => $this->services->marked_hour,
            'marked_service' => $this->services->marked_service, 
            'note' => $this->services->note,
            'id_user' => $this->services->user_id,
            'client_id' => $this->services->client_id,
            'appointment_id' => $this->services->appointment_id,
            'service_id' => $this->services->id,
            'service_status' => false
        ];
    }
}
