<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationComponent extends Component
{
    public $user;

    protected $listeners = ['refreshTacheDetails' => '$refresh'];
    
    public function mount(){
        $this->user = Auth::user();
    }

    public function marckReadNotification(){
        $this->user->unreadNotifications->markAsRead();
        return redirect()->route('taches.index');
    }

    public function render()
    {
        return view('livewire.notification-component');
    }
}
