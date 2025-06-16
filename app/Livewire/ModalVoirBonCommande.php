<?php

namespace App\Livewire;

use App\Models\BonCommande;
use Livewire\Component;

class ModalVoirBonCommande extends Component
{
    public $bon;

    public function mount(BonCommande $bonCommande){
        $this->bon = BonCommande::find($bonCommande->id);
    }

    public function render()
    {
        return view('livewire.modal-voir-bon-commande');
    }
}
