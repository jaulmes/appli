<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Compte;
use Livewire\Component;

class FormulaireVenteProduit extends Component
{
    public $cartContent;

    protected $listeners = ['ProduitAjoute' => 'updateCart',
                            'quantiteModifier' =>'updateCart'];

    public function updateCart(){
        $this->cartContent = \Cart::getContent();

    }
    
    public function render()
    {
        $comptes = Compte::all();
        $clients = Client::all();
        return view('livewire.formulaire-vente-produit', 
            [
                'comptes' => $comptes,
                'clients' => $clients
            ]
        );
    }
}
