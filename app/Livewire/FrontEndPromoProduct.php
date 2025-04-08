<?php

namespace App\Livewire;

use App\Models\Produit;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class FrontEndPromoProduct extends Component
{

    public $produits;
    public $cart = [];

    public $listeners = [
        'addToCartProduct' => 'addToCart',
    ];

    public function addToCart($id){
        $produit = Produit::where('id', $id)->first();
        $cart = session()->get('frontEndCart', []);

        if(isset($cart[$produit->id])){
            $cart[$produit->id]['quantity'] += 1;
        }else{
            $cart[$produit->id] = [
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
        
        Session::put('frontEndCart', $cart);
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
