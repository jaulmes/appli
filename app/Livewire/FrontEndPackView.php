<?php

namespace App\Livewire;

use App\Models\Pack;
use Livewire\Component;

class FrontEndPackView extends Component
{
    public $packs;

    public function addPackToCart($packId)
    {
        $cart = session()->get('parnier_pack', []);

        $produits = Pack::find($packId)->produits;

        
        if (isset($cart[$packId])) {
            $cart[$packId]['quantity']++;
        } else {
            $cart[$packId] = [
                "id" => $packId,
                "image" => $this->packs->find($packId)->image,
                "titre" => $this->packs->find($packId)->titre,
                "prix" => $this->packs->find($packId)->prix,
                "quantity" => 1,
                "produits" => $this->packs->find($packId)->produits,
            ];
        }

        $this->dispatch('ajouter_pack_panier');
        session()->put('parnier_pack', $cart);
    }

    public function mount(){
        $this->packs = Pack::all();
    }

    public function render()
    {
        return view('livewire.front-end-pack-view');
    }
}
