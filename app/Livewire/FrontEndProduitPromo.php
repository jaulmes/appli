<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Produit;

class FrontEndProduitPromo extends Component
{
    public $produits;

    public function mount(){
        $this->produits = Produit::where('status_promo', 1)->get();
    }

    public function render()
    {
        return view('livewire.front-end-produit-promo');
    }
}
