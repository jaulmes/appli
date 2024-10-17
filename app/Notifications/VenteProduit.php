<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VenteProduit extends Notification
{
    use Queueable;

    public $produits;

    /**
     * Create a new notification instance.
     */
    public function __construct($produits)
    {
        $this->produits = $produits;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject('Nouveau produit enregistré')
        ->greeting('Bonjour,')
        ->line('Un nouveau produit a été enregistré : ' . $this->produits->titre)
        ->line('Description: ' . $this->produits->description)
        ->line('Prix: ' . $this->produits->price . 'francs cfa')
        ->line('Merci d\'utiliser notre application !');
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
