<?php

namespace App\Livewire;

use App\Models\Produit;
use Livewire\Component;

class CatalogueAprovisionnementProduit extends Component
{
    public function render()
    {
        $produits = Produit::all();
        return view('livewire.catalogue-aprovisionnement-produit', compact('produits'));
    }
}
