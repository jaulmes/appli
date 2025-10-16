<?php

namespace App\Livewire;

use App\Models\Compte;
use Livewire\Component;

class ModalValiderAprovisionnement extends Component
{
    public $produitPanier;
    
    protected $listeners = ['quantiteModifier' => 'updateCart',
                            'ProduitAjoute' => 'updateCart'];

    public function updateCart(){
        $this->produitPanier = session()->get('cart', []);
    }

    public function panierTotal(){
        $total = 0;
        foreach($this->produitPanier as $item){
            $total += (int)$item['prix_achat'] * $item['quantity'];
        }
        return $total;
    }

    public function mount(){
        $this->produitPanier = session()->get('cart', []);
    }
    public function render()
    {
        $comptes = Compte::all();
        return view('livewire.modal-valider-aprovisionnement', compact('comptes'));
    }
}
