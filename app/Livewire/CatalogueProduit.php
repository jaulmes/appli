<?php

namespace App\Livewire;

use App\Models\Categori;
use App\Models\Produit;
use Livewire\Component;

class CatalogueProduit extends Component
{
    public $produits = []; //liste des produits
    public $categories = [];
    public $query = '';
    public $test = '0';
    public $categori = 'categorie';

    // //recuperation de tous les produits dans la BD
    public function mount(){   
        $this->produits = Produit::all();
        $this->categories = Categori::all();
    }

    //ajout de nouveau produit dans le panier
    public function ajouterPanier($id){
        $produits = Produit::find($id);

        \Cart::add(array(
            'id' => $produits->id, // inique row ID
            'name' => $produits->name,
            'price' => $produits->price,
            'quantity' => 1,
            'attributes' => [            
                'prix_technicien' => $produits->prix_technicien,
                'prix_minimum' => $produits->prix_minimum,
                'price' => $produits->price,
                'prix_achat' => $produits->prix_achat,]
        ))->associate($produits);

    
        /**
         * emmission d'un evenement apres ajout du produit 
         * dans le panier pour ecouter et rafraichir le composant mon panier
         * */
        $this->dispatch('ProduitAjoute');
    }

    public function update_query(){
        //$word = $this->query;
        $word = '%' . $this->query . '%';
        $this->produits = Produit::where('name', 'like', '%'. $word . '%')
                                    ->orWhere('description', 'like', '%'. $word . '%')
                                    ->get();
    }

    //filtre des produits par categories
    public function filtreProduit($id){
        
        $categoris = Categori::find( $id);
        $this->categori = $categoris->titre;
        $this->produits = Produit::where('categori_id', $id)
                                    ->orderBy('name', 'asc')
                                    ->get();
    }

    public function render()
    {
        return view('livewire.catalogue-produit');
    }
}
