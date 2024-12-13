<?php

namespace App\Livewire;

use App\Models\Compte;
use Livewire\Component;

class ModalValiderAprovisionnement extends Component
{
    public $produitPanier;
    protected $listeners = ['quantiteModifier' => 'updateCart'];

    public function updateCart(){
        $this->produitPanier = \Cart::getContent();
    }
    public function render()
    {
        $comptes = Compte::all();
        return view('livewire.modal-valider-aprovisionnement', compact('comptes'));
    }
}
