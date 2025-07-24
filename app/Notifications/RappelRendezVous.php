<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RappelRendezVous extends Notification
{
    use Queueable;

    public $suivi;
    public $message;
    /**
     * Create a new notification instance.
     */
    public function __construct($suivi, $message)
    {
        
        $this->suivi = $suivi;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        
        return (new MailMessage)
                    ->subject('Rappel de rendez-vous')
                    ->line($this->message)
                    ->line('Client : ' . $this->suivi->clients->nom)
                    ->line('Date : ' . $this->suivi->prochain_rendez_vous)
                    ->action('Voir le suivi', url('suivi/' . $this->suivi->id));
    }

    public function toDatabase( $notifiable)
    {
        return [
            'titre' => 'Rappel de rendez-vous',
            'suivi_id' => $this->suivi->id,
            'message' => $this->message,
            'client' => $this->suivi->clients->nom,
            'date' => $this->suivi->prochain_rendez_vous,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
