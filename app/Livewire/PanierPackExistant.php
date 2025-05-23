<?php

namespace App\Livewire;

use Livewire\Component;

class PanierPackExistant extends Component
{
    public $cart = [], $new_price = [], $quantity = [];
    public $total = 0;

    protected $listeners = [
        'ajouter_pack_panier' => 'mount',
    ];

    public function mount()
    {
        $this->cart = session()->get('parnier_pack', []);
        $this->calculateTotal();
    }
    
    public function calculateTotal()
    {
        $this->total = 0;
        foreach ($this->cart as $item) {
            $this->total += $item['prix'] * $item['quantity'];
        }
        return $this->total;
    }
    public function retirerPack($id)
    {
        if (isset($this->cart[$id])) {
            unset($this->cart[$id]);
            session()->put('parnier_pack', $this->cart);
            $this->calculateTotal();
        }
    }

    public function update_prix($id){
        if(isset($this->cart[$id])){
            $this->cart[$id]['prix'] = $this->new_price[$id];
            session()->put('parnier_pack', $this->cart);
            $this->calculateTotal();
        }

        $this->dispatch('prix_modifie');
    }

    public function modifierQuantite($id)
    {
        if (isset($this->cart[$id])) {
            if ($this->quantity[$id] <= 0) {
                $this->quantity[$id] = 1;
            }
            $this->cart[$id]['quantity'] = $this->quantity[$id];
            session()->put('parnier_pack', $this->cart);
            $this->calculateTotal();
            $this->dispatch('quantite_modifie');
        }
    }
    public function viderPanier()
    {
        session()->forget('parnier_pack');
        $this->cart = [];
        $this->total = 0;
    }
    public function render()
    {
        return view('livewire.panier-pack-existant');
    }
}
