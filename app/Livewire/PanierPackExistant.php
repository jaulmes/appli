<?php

namespace App\Livewire;

use Livewire\Component;

class PanierPackExistant extends Component
{
    public $cart = [], $new_price = [], $quantity = [];
    public $total = 0;

    protected $listeners = [
        'ajouter_pack_panier' => 'mount',
        'produit_retirer_pack' => '$refresh',
        'prix_modifie' => 'mount',
        'quantite_modifie' => 'mount'
    ];

    public function mount()
    {
        $this->cart = session()->get('cart', []);
        $this->calculateTotal();
    }
    
    public function calculateTotal()
    {
        $this->total = 0;
        foreach ($this->cart as $item) {
            $this->total += $item['price'] * $item['quantity'];
        }
        return $this->total;
    }
    //a retirer
    // public function retirerPack($id)
    // {
    //     if (isset($this->cart[$id])) {
    //         unset($this->cart[$id]);
    //         session()->put('parnier_pack', $this->cart);
    //         $this->calculateTotal();
    //     }
    // }
    public function retirerProduit($id){
        if(isset($this->cart[$id])){
            unset($this->cart[$id]);
            session()->put('cart', $this->cart);
            $this->calculateTotal();
        }
        $this->dispatch('produit_retirer_pack');
        return redirect()->route('panier.pack.show');
    }

    public function update_prix($id){
        if(isset($this->cart[$id])){
            $this->cart[$id]['price'] = $this->new_price[$id];
            session()->put('cart', $this->cart);
            $this->calculateTotal();
        }

        $this->dispatch('prix_modifie');
    }

    public function modifierQuantite($id)
    {
        if (isset($this->cart[$id])) {
            //dd($this->cart);
            if ($this->quantity[$id] <= 0) {
                $this->quantity[$id] = 1;
            }
            $this->cart[$id]['quantity'] = $this->quantity[$id];
            session()->put('cart', $this->cart);
            $this->calculateTotal();
            $this->dispatch('quantite_modifie');
        }
    }
    public function viderPanier()
    {
        session()->forget('cart');
        $this->cart = [];
        $this->total = 0;
    }
    public function render()
    {
        return view('livewire.panier-pack-existant');
    }
}
