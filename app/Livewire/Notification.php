<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Notification extends Component
{
    public $users;

    public function mount()
    {
        $this->users = Auth::user();
    }

    public function loadNotifications(){
        $this->users = Auth::user();
    }

    // Marque une notification comme lue et la retire de l'affichage
    public function markAsReadAndDismiss($notificationId)
    {
        if (!Auth::check()) return;

        $notification = Auth::user()->notifications->find($notificationId);

        if ($notification && !$notification->read()) {
            $notification->markAsRead();
        }
    }

    public function render()
    {
        return view('livewire.notification');
    }
}
