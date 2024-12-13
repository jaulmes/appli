<?php

namespace App\Livewire;

use App\Models\Produit;
use Livewire\Component;
use Darryldecode\Cart\Cart;

class PanierAprovisionnement extends Component
{
    public $cartContent;

    protected $listeners = ['ProduitAjoute' => 'updateCart'];

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

    public function updateCart(){
        $this->cartContent = \Cart::getContent();
    }
    public function render()
    {
        return view('livewire.panier-aprovisionnement');
    }
}
