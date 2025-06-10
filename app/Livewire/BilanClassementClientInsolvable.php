<?php

namespace App\Livewire;

use App\Models\Client;
use Carbon\Carbon;
use Livewire\Component;

class BilanClassementClientInsolvable extends Component
{
    public $moisSelectionne;
    public $clients;
    public $ventes;
    public $installations;
    public function afficher()
    {
        
        $this->clients = Client::where(function ($query) {
            $query->whereHas('ventes', function ($q) {
                $q->whereYear('created_at', Carbon::parse($this->moisSelectionne)->year)
                ->whereMonth('created_at', Carbon::parse($this->moisSelectionne)->month)
                ->where('statut', 'non termine');
            })->orWhereHas('installations', function ($q) {
                $q->whereYear('created_at', Carbon::parse($this->moisSelectionne)->year)
                ->whereMonth('created_at', Carbon::parse($this->moisSelectionne)->month)
                ->where('statut', 'non termine');
            });
    })
    ->with([
        'ventes' => function ($query) {
            $query->whereYear('created_at', Carbon::parse($this->moisSelectionne)->year)
                  ->whereMonth('created_at', Carbon::parse($this->moisSelectionne)->month)
                  ->where('statut', 'non termine')
                  ->with('produits')
                  ->latest();
        },
        'installations' => function ($query) {
            $query->whereYear('created_at', Carbon::parse($this->moisSelectionne)->year)
                  ->whereMonth('created_at', Carbon::parse($this->moisSelectionne)->month)
                  ->where('statut', 'non termine')
                  ->with('produits')
                  ->latest();
        }
    ])
    ->get();

// Classer les clients par dettes décroissantes
$this->clients = $this->clients->sortByDesc(function ($client) {
    $totalDettes = 0;

    foreach ($client->ventes as $vente) {
        $totalDettes += ($vente->NetAPayer - $vente->montantVerse);
    }

    foreach ($client->installations as $installation) {
        $totalDettes += ($installation->NetAPayer - $installation->montantVerse);
    }

    return $totalDettes;
});
    }
    public function mount($moi)
    {
        $this->moisSelectionne = $moi;
        $this->afficher();
    }
    public function render()
    {
        return view('livewire.bilan-classement-client-insolvable');
    }
}
