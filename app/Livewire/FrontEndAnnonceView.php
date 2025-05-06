<?php

namespace App\Livewire;

use App\Models\Annonce;
use Livewire\Component;

class FrontEndAnnonceView extends Component
{
    public $annonces;

    public function mount()
    {
        $this->annonces = Annonce::all();
    }
    public function render()
    {
        return view('livewire.front-end-annonce-view');
    }
}
