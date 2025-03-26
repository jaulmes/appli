<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Compte;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class FormulaireVenteProduit extends Component
{
    public $cartContent;
    public $montantTotal;

    protected $listeners = ['ProduitAjoute' => 'updateCart',
                            'quantiteModifier' =>'updateCart'];

    public function montantTotal(){
        $this->cartContent = Session::get('cart', []);
        $montantTotal = 0;
        foreach($this->cartContent as $item){
            $montantTotal += $item['quantity'] * (int)$item['price'];
        }
        return $montantTotal;
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
