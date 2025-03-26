<?php

namespace App\Livewire;

use App\Models\Client;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class FormulaireProformat extends Component
{
    public $clients;
    public $cartContent;
    public $montantTotal;

    protected $listeners = ['ProduitAjoute' => 'montantTotal',
                            'quantiteModifier' =>'montantTotal',
                            'prix_change' => 'montantTotal',
                            'ProduitRetire' => 'montantTotal',
                            'panierVide' => 'montantTotal'];

    public function montantTotal(){
        $this->cartContent = Session::get('cart', []);
        $montantTotal = 0;
        foreach($this->cartContent as $item){
            $montantTotal = $montantTotal + $item['quantity'] * (int)$item['price'];
        }
        return $montantTotal;
    }


    public function mount(){
        $this->clients = Client::all();
        $this->cartContent = Session::get('cart', []);
    }

    public function render()
    {
        return view('livewire.formulaire-proformat');
    }
}
