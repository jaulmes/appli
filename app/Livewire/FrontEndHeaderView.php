<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Session;
use Livewire\Component;

class FrontEndHeaderView extends Component
{
    public $cart = [];
    public $qte, $totalProduitsDifferents;


    protected $listeners = [
        'ProduitAjoute' => 'mount', 
        'ProduitRetire' => 'mount',
        'panierVide' => 'mount'
    ];

    public function mount(){

        $this->cart = Session::get('frontEndCart', []);

        $this->qte = 0; // Nombre total d'articles dans le panier
        $this->qte = count($this->cart); // Nombre de produits distincts
    }


    public function render()
    {
        return view('livewire.front-end-header-view');
    }
}
