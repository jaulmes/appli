<?php

namespace App\Livewire;

use App\Models\Produit;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class FrontEndPromoProduct extends Component
{

    public $produits;
    public $cart = [];

    public function addToCart($id){
        $produit = Produit::find($id);
        if(isset($this->cart[$id])){
            $this->cart[$id]['quantity'] += 1;
        }else{
            $this->cart[$id] = [
                'quantity' => 1,
                'id' => $produit->id,
                'name' => $produit->name,
                'image' => $produit->image_produit,
                'price' => $produit->price,
                'prix_catalogue' => $produit->price,
                'prix_promo' => $produit->prix_promo,
                'status_promo' => $produit->status_promo
            ];
        }
        
        Session::put('cart', $this->cart);
        $this->dispatch('ProduitAjoute');
    }

    public function mount(){
        $this->produits = Produit::where('status_promo', 1)->get();
    }
    public function render()
    {
        return view('livewire.front-end-promo-product');
    }
}
