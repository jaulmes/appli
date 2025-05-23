<?php

namespace App\Livewire;

use Livewire\Component;

class PackDetail extends Component
{
    public $pack;
    public $produits;

    public function mount($pack)
    {
        $this->pack = $pack;
        $this->produits = $pack->produits;
    }
    public function addToCart($packId)
    {
        $cart = session()->get('parnier_pack', []);

        if (isset($cart[$packId])) {
            $cart[$packId]['quantity']++;
        } else {
            $cart[$packId] = [
                "name" => $this->pack->find($packId)->titre,
                "price" => $this->pack->find($packId)->prix,
                "quantity" => 1,
                "produits" => $this->packs->find($packId)->produits,
            ];
        }

        session()->put('parnier_pack', $cart);
        session()->flash('success', 'Produit ajouté au panier !');
    }

    public function render()
    {
        return view('livewire.pack-detail');
    }
}
