<?php

namespace App\Livewire;

use App\Models\Produit;
use Livewire\Component;

class FrontEndModalAllProduct extends Component
{
    public $produit_promo;
    public $produit_non_promo;
    public $produit_id;
    public $prix_promo = [];
    public $status_promo;

    public $produit_selectionne = [];

    public function submit(){
        foreach ($this->produit_selectionne as $productId) {
            
            $produit = Produit::find($productId);
            if ($produit) {
                $produit->status_promo = 1;
                $produit->prix_promo = $this->prix_promo[$productId];
                //dd($produit->status_promo, $produit->prix_promo);
                $produit->save();
            }
        }
        session()->flash('message', 'Produit en promotion avec succès');
        return redirect()->route('frontend.admin.allPromoProduit');
    }

    public function mount(){
        $this->produit_promo = Produit::where('status_promo', 1)->get();
        $this->produit_non_promo = Produit::where('status_promo', 0)->get();
    }
    public function render()
    {
        return view('livewire.front-end-modal-all-product');
    }
}
