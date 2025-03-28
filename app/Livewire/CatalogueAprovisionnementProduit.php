<?php

namespace App\Livewire;

use App\Models\Categori;
use App\Models\Produit;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class CatalogueAprovisionnementProduit extends Component
{
    public $query, $cart, $categori, $categories;
    public $produits = [];


    protected $listeners = [
        'panierVide' => 'mount',
        'prix_change' => 'mount',
        'ProduitRetire' => 'mount',
        'quantiteModifier' => 'mount'
        ];

    public function mount(){   
        $this->produits = Produit::all();
        $this->categories = Categori::all();
        $this->cart = Session::get('cart', []);
    }
    
    public function update_query(){
        $word = '%' . $this->query . '%';
        $this->produits = Produit::where('name', 'like', '%'. $word . '%')
                                    ->orWhere('description', 'like', '%'. $word . '%')
                                    ->get();
        $this->cart = Session::get('cart', []); 
    }

    //filtre des produits par categories
    public function filtreProduit($id){
        
        $categoris = Categori::find( $id);
        $this->categori = $categoris->titre;
        $this->produits = Produit::where('categori_id', $id)
                                    ->orderBy('name', 'asc')
                                    ->get();
        $this->cart = Session::get('cart', []); 
    }

    public function addToCart($id){
        $produit = Produit::find($id);
        if(isset($this->cart[$id])){
            $this->cart[$id]['quantity'] += 1;
        }else{
            $this->cart[$id] = [
                'quantity' => 1,
                'id' => $produit->id,
                'name' => $produit->name,
                'prix_achat' => $produit->prix_achat,
            ];
        }
        
        Session::put('cart', $this->cart);
        $this->dispatch('ProduitAjoute');
    }

    public function render()
    {
        return view('livewire.catalogue-aprovisionnement-produit');
    }
}
