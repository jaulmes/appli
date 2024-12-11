<?php

namespace App\Livewire;

use App\Models\Produit;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use Livewire\Component;

class CatalogueProduit extends Component
{
    public $produits; //liste des produits

    //recuperation de tous les produits dans la BD
    public function mount(){
        $this->produits = Produit::all();
    }

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
        
        return view('livewire.catalogue-produit');
    }
}
