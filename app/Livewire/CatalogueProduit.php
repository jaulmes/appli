<?php

namespace App\Livewire;

use App\Models\Produit;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use Livewire\Component;

class CatalogueProduit extends Component
{
    public $produits = []; //liste des produits
    public $query = '';

    //recuperation de tous les produits dans la BD
    public function mount(){   
        //$this->updatedQuery();
        $word = '%'. $this->query .'%';
        if(strlen($this->query)>0){
            $this->produits = Produit::where('name', 'like', '%'. $this->query .'%')
                        ->orWhere('description', 'like', '%'. $this->query .'%')
                        ->get();
        }
        else{
            $this->produits = Produit::all();
        }
    }

    //ajout de nouveau produit dans le panier
    public function ajouterPanier($id){
        $produits = Produit::find($id);
        
        // \Cart::add($produits->id, 
        //             $produits->name, 
        //             $produits->price, 
        //             1,
        //             'options' -> [
        //                 'prix_technicien' -> $product->prix_technicien,
        //                 'prix_minimum' -> $product->prix_minimum,
        //                 'prix_achat' -> $product->prix_achat,
        //             ], array())
        //             ->associate($produits);
        \Cart::add(array(
            'id' => $produits->id, // inique row ID
            'name' => $produits->name,
            'price' => $produits->price,
            'quantity' => 1,
            'attributes' => [            
                'prix_technicien' => $produits->prix_technicien,
                'prix_minimum' => $produits->prix_minimum,
                'price' => $produits->price,]
        ));

    
        /**
         * emmission d'un evenement apres ajout du produit 
         * dans le panier pour ecouter et rafraichir le composant mon panier
         * */
        $this->dispatch('ProduitAjoute');
    }

    public function updatedQuery(){
        $word = '%'. $this->query .'%';
        if(strlen($this->query)>0){
            $this->produits = Produit::where('name', 'like', $word)
                        ->orWhere('description', 'like', $word)
                        ->get();
        }
        else{
            $this->produits = Produit::all();
        }
        
    }


    public function render()
    {
        
        //dd($produits);  
        return view('livewire.catalogue-produit');
    }
}
