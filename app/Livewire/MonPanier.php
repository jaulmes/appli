<?php

namespace App\Livewire;

use App\Models\Produit;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use Livewire\Component;

class MonPanier extends Component
{
    public $cartContent;

    protected $listeners = ['ProduitAjoute' => 'updateCart'];

    public function updateCart(){
        $this->cartContent = \Cart::getContent();
    }

    //mettre a jour la quantite
    public function ajouterQuantite($id){
        //je recupere le produit dans le systeme avec son Id
        $produits = Produit::find($id);
        //je recupere le produit dans le panier
        $item = \Cart::get($produits->id);
        //dd($item->quantity);
        $quantity = $item->quantity ++;

        \Cart::update($item->id, ['quantity' => $quantity ]);

        $this->dispatch('quantiteModifier');
    }

    //mettre a jour la quantite
    public function diminuerQuantite($id){
        //je recupere le produit dans le systeme avec son Id
        $produits = Produit::find($id);
        //je recupere le produit dans le panier
        $item = \Cart::get($produits->id);
        if($item->quantity > 0){
            $quantity = $item->quantity --;

            \Cart::update($item->id, ['quantity' => $quantity ]);
    
            $this->dispatch('quantiteModifier');
        }

    }

    public function render()
    {
        return view('livewire.mon-panier');
    }
}
