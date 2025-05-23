<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Session;
use Livewire\Component;

class FrontEndHeaderView extends Component
{
    public $cart = [], $panier_pack = [];
    public $qte, $totalProduitsDifferents;


    protected $listeners = [
        'ProduitAjoute' => 'mount', 
        'ProduitRetire' => 'mount',
        'ajouter_pack_panier' => 'mount',
        'panierVide' => 'mount'
    ];

    public function mount(){

        $this->cart = Session::get('frontEndCart', []);
        $this->panier_pack = Session::get('parnier_pack', []);


        $this->qte = 0; // Nombre total d'articles dans le panier
        $this->qte = count($this->cart + $this->panier_pack); // Nombre de produits distincts
    }


    public function render()
    {
        return view('livewire.front-end-header-view');
    }
}
