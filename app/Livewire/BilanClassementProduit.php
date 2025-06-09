<?php

namespace App\Livewire;

use App\Models\Produit;
use Carbon\Carbon;
use Livewire\Component;

class BilanClassementProduit extends Component
{
    public $moisSelectionne;
    public $produits ;

    public function afficher()
    {
        $this->produits = Produit::with([
            'ventes' => function($query) {
                $query->whereYear('ventes.created_at', Carbon::parse($this->moisSelectionne)->year)
                    ->whereMonth('ventes.created_at', Carbon::parse($this->moisSelectionne)->month)
                    ->latest();
                },
            'installations' => function($query) {
                $query->whereYear('installations.created_at', Carbon::parse($this->moisSelectionne)->year)
                    ->whereMonth('installations.created_at', Carbon::parse($this->moisSelectionne)->month)
                    ->latest();
            }
        ])->get();

        // Classer les produits par montant total des ventes
        $this->produits = $this->produits->sortByDesc(function($produit) {
            $totalVente = 0;
            foreach ($produit->ventes as $vente) {
                $totalVente +=  $vente->pivot->quantity;
            }
            return $totalVente;
        });
    }

    public function mount($moi){
        $this->moisSelectionne = $moi;
        $this->afficher();
    }
    public function render()
    {
        return view('livewire.bilan-classement-produit');
    }
}
