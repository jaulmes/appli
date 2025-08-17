<?php

namespace App\Livewire;

use App\Models\Achat;
use Livewire\Component;

class BilanInvestissement extends Component
{
    public $moisSelectionne, $montantInvesti, $beneficeAttendu, 
        $beneficeReel, $achats = [];

    public function afficher(){

        $this->achats = Achat::with('produits')->where('created_at', '>=', now()->startOfMonth())
            ->where('created_at', '<=', now()->endOfMonth())
            ->whereYear('created_at', now()->year)
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($this->achats as $achat) {
            foreach ($achat->produits as $produit) {
                $this->montantInvesti += $produit->pivot->quantity * $produit->prix_achat;
            }
        }

    }

    public function mount($moi){
        $this->moisSelectionne = $moi;
        $this->afficher();
    }

    public function render()
    {
        return view('livewire.bilan-investissement');
    }
}
