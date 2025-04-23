<?php

namespace App\Livewire;

use App\Models\Produit;
use Livewire\Component;

class FrontEndAllPromoProduitAdmin extends Component
{
    public $produit_promo;

    public function mount(){
        $this->produit_promo = Produit::where('status_promo', 1)
                                ->orderByRaw('position_promo IS NULL, position_promo ASC')
                                ->get();
    }

    public function annulerPromo($id){
        $produit = Produit::find($id);
        if ($produit) {
            $produit->status_promo = 0;
            $produit->position_promo = null;
            $produit->save();
            session()->flash('message', 'Promotion annulée avec succès.');
            $this->mount();
        } else {
            session()->flash('error', 'Produit non trouvé.');
            return;
        }
    }
    public function render()
    {
        return view('livewire.front-end-all-promo-produit-admin');
    }
}
