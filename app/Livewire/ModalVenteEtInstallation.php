<?php

namespace App\Livewire;

use Livewire\Component;

class ModalVenteEtInstallation extends Component
{
    public $cartContent;//contenu du panier

    //ecoute l'evenement produitAjoute et execute la fonction updateCart 
    protected $listeners = ['ProduitAjoute' => 'updateCart',
                            'quantiteModifier' =>'updateCart'];


    //fonction qui met a jour le panier
    public function updateCart(){
        $this->cartContent = \Cart::getContent();
    }

    public function render()
    {
        return view('livewire.modal-vente-et-installation');
    }
}
