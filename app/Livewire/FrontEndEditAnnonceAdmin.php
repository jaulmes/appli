<?php

namespace App\Livewire;

use App\Models\Annonce;
use Livewire\Component;

class FrontEndEditAnnonceAdmin extends Component
{
    public $annonce;

    public function mount($annonce){
        $this->annonce = Annonce::find($annonce->id);
    }
    public function render()
    {
        return view('livewire.front-end-edit-annonce-admin');
    }
}
