<?php

namespace App\Livewire;

use App\Models\Service;
use Livewire\Component;

class FrontEndServiceView extends Component
{
    public $services;

    public function mount()
    {
        $this->services = Service::where('status', 'actif')->get();
    }

    public function render()
    {
        return view('livewire.front-end-service-view');
    }
}
