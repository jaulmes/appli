<?php

namespace App\Livewire;

use App\Models\Produit;
use Livewire\Component;

class CatalogueAprovisionnementProduit extends Component
{
    //ajout de nouveau produit dans le panier
    public function ajouterPanier($id){
        $produits = Produit::find($id);
        
        \Cart::add($produits->id, $produits->name, $produits->price, 1,array())
                    ->associate($produits);

        /**
         * emmission d'un evenement apres ajout du produit 
         * dans le panier pour ecouter et rafraichir le composant mon panier
         * */
        $this->dispatch('ProduitAjoute');
    }
    public function render()
    {
        $produits = Produit::all();
        return view('livewire.catalogue-aprovisionnement-produit', compact('produits'));
    }
}
