<?php

namespace App\Livewire;

use App\Models\Vente;
use Livewire\Component;

class AfficherVentes extends Component
{
    public $ventes = [];

    public function mount(){
        $this->ventes = Vente::all();
    }
    
    public function render()
    {
        return view('livewire.afficher-ventes');
    }
}
