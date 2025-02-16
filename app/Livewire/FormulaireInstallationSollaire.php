<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Compte;
use Livewire\Component;

class FormulaireInstallationSollaire extends Component
{
    public $cartContent;//contenu du panier

    //ecoute l'evenement produitAjoute et execute la fonction updateCart 
    protected $listeners = ['ProduitAjoute' => 'updateCart',
                            'quantiteModifier' => 'updateCart'];

    //fonction qui met a jour le panier
    public function updateCart(){
        $this->cartContent = \Cart::getContent();
    }
    public function render()
    {
        $comptes = Compte::all();
        $clients = Client::all();
        return view('livewire.formulaire-installation-sollaire', 
            [
                'clients' => $clients,
                'comptes' => $comptes
            ]
        );
    }
}
