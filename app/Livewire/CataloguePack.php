<?php

namespace App\Livewire;

use App\Models\Produit;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class CataloguePack extends Component
{
    public $cart = [], $new_price = [], $quantity = [], $categories = [], $produits = [];

    public function addToCart($id)
    {
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

        session()->put('cart', $this->cart);
        $this->dispatch('produit_ajoute_pack');
    }

    public function mount(){
        $this->produits = Produit::all();
        $this->cart = session()->get('cart', []);
    }

    public function render()
    {
        return view('livewire.catalogue-pack');
    }
}
