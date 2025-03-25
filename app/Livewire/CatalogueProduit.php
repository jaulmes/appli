<?php

namespace App\Livewire;

use App\Models\Categori;
use App\Models\Client;
use App\Models\Produit;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class CatalogueProduit extends Component
{
    public $produits = []; //liste des produits
    public $categories = [];
    public $query = '';
    public $test = '0';
    public $categori = 'categorie';
    public $cart = [];

    protected $listeners = ['ProduitAjoute' => 'mount',
                            'panierVide' => 'mount',
                            'prix_change' => 'mount',
                            'ProduitRetire' => 'mount',
                            'quantiteModifier' => 'mount'
                        ];

    // //recuperation de tous les produits dans la BD
    public function mount(){   
        $this->produits = Produit::all();
        $this->categories = Categori::all();
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
                'price' => $produit->price,
                'prix_catalogue' => $produit->price,
                'prix_technicien' => $produit->prix_technicien,
                'prix_minimum' => $produit->prix_minimum,
                'prix_achat' => $produit->prix_achat,
                'prix_promo' => $produit->prix_promo,
            ];
        }
        
        Session::put('cart', $this->cart);
        $this->dispatch('ProduitAjoute');
    }

    public function viderPanier(){
        $this->cart = [];

        $this->cart = Session::get('cart', []); 
        session()->forget('cart');
    }


    public function update_query(){
        //$word = $this->query;
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

    public function render()
    {
        return view('livewire.catalogue-produit');
    }
}
