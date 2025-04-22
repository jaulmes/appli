<?php

namespace App\Livewire;

use App\Models\Produit;
use Livewire\Component;

class FrontEndModalModifierDetailPromo extends Component
{
    public $produit_promo;
    public $produit_non_promo;
    public $prix_promo;
    public $position_catalogue;
    public $position_promo;
    public $produit;
    public $produits;




    public function mount($produit)
    {
        $this->produit_promo = Produit::where('status_promo', 1)->get();
        $this->produit_non_promo = Produit::where('status_promo', 0)->get();
        $this->produit = Produit::find($produit->id);
        $this->produits = Produit::all();
    }

    public function validerModification(){
        if($this->position_catalogue == null){
            $this->produit->position_catalogue = $this->produit->position_catalogue;
        } else {
            $this->produit->position_catalogue = $this->position_catalogue;
        }
        if($this->position_promo == null){
            $this->produit->position_promo = $this->produit->position_promo;
        } else {
            $this->produit->position_promo = $this->position_promo;
        }
        if ($this->prix_promo == null) {
            $this->produit->prix_promo = $this->produit->prix_promo;
        } else {
            $this->produit->prix_promo = $this->prix_promo;
        }
        $this->produit->status_promo = 1;
        $this->produit->save();
        session()->flash('message', 'modification effectue avec succès !');
        return redirect()->route('frontend.admin.allPromoProduit');
    }

    public function render()
    {
        return view('livewire.front-end-modal-modifier-detail-promo');
    }
}
