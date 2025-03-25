<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Session;
use Livewire\Component;

class ModalVenteEtInstallation extends Component
{
    public $cart;//contenu du panier

    //ecoute l'evenement produitAjoute et execute la fonction updateCart 
    protected $listeners = ['ProduitAjoute' => 'updateCart',
                            'quantiteModifier' =>'updateCart',
                            'prix_change' => 'updateCart'];


    //fonction qui met a jour le panier
    public function panierTotal(){
        $this->cart = Session::get('cart', []);
        $total = 0;
        foreach($this->cart as $item){
            $total =$total + $item['quantity'] * $item['price'];
        }
        return $total;
    }

    public function render()
    {
        return view('livewire.modal-vente-et-installation');
    }
}
