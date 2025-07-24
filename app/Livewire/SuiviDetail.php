<?php

namespace App\Livewire;

use Livewire\Component;

class SuiviDetail extends Component
{
    public $suivi, $observations = [];
    public $suiviId;

    public function mount($suivi)
    {
        $this->suivi = $suivi;
    }
    public function render()
    {
        return view('livewire.suivi-detail');
    }
}
