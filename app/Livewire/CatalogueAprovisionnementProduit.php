<?php

namespace App\Livewire;

use App\Models\Produit;
use Livewire\Component;

class CatalogueAprovisionnementProduit extends Component
{
    //ajout de nouveau produit dans le panier
    public function ajouterPanier($id){
        $produits = Produit::find($id);
        
        \Cart::add(array(
            'id' => $produits->id, // inique row ID
            'name' => $produits->name,
            'price' => $produits->prix_achat,
            'quantity' => 1,
            'attributes' => [            
                'prix_technicien' => $produits->prix_technicien,
                'prix_minimum' => $produits->prix_minimum,
                'prix_achat' => $produits->prix_achat,
                'price' => $produits->price
            ]
        ));

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
