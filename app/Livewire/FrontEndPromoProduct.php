<?php

namespace App\Livewire;

use App\Models\Produit;
use Livewire\Component;

class FrontEndPromoProduct extends Component
{

    public $produits;

    public function mount(){
        $this->produits = Produit::where('status_promo', 1)->get();
    }
    public function render()
    {
        return view('livewire.front-end-promo-product');
    }
}
