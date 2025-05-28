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
                "id" => $packId,
                "image" => $this->pack->find($packId)->image,
                "titre" => $this->pack->find($packId)->titre,
                "prix" => $this->pack->find($packId)->prix,
                "quantity" => 1,
                "produits" => $this->pack->find($packId)->produits,
            ];
        }

        $this->dispatch('ajouter_pack_panier');
        session()->put('parnier_pack', $cart);
        session()->flash('success', 'Produit ajouté au panier !');
    }

    public function render()
    {
        return view('livewire.pack-detail');
    }
}
