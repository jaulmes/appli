<?php

namespace App\Livewire;

use App\Models\Produit;
use Livewire\Component;

class CatalogueProduit extends Component
{
    public function render()
    {
        $produits = Produit::all();
        return view('livewire.catalogue-produit', compact('produits'));
    }
}
