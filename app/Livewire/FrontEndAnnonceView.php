<?php

namespace App\Livewire;

use App\Models\Annonce;
use Livewire\Component;

class FrontEndAnnonceView extends Component
{
    public $annonces, $voir_annonce = true;

    public function toggleVoirAnnonce()
    {
        $this->voir_annonce = !$this->voir_annonce;
    }

    public function mount()
    {
        $this->annonces = Annonce::where('status', 'actif')->get();
    }
    public function render()
    {
        return view('livewire.front-end-annonce-view');
    }
}
