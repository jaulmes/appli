<?php

namespace App\Livewire;

use App\Models\Produit;
use Livewire\Component;

class FrontEndNosProduitView extends Component
{
    public $produits;

    public function mount(){
        $this->produits = Produit::inRandomOrder()->take(9)->get();
    }

    public function addProductToCart($id){
        $this->dispatch('addToCartProduct', [$id]);
    }

    public function render()
    {
        return view('livewire.front-end-nos-produit-view');
    }
}
