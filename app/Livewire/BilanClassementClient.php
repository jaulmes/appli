<?php

namespace App\Livewire;

use App\Models\Client;
use Carbon\Carbon;
use Livewire\Component;

class BilanClassementClient extends Component
{
    public $moisSelectionne;
    public $clients;

    public function afficher(){
        $this->clients = Client::with([
            'ventes' => function($query) {
                $query->whereYear('created_at', Carbon::parse($this->moisSelectionne)->year)
                        ->whereMonth('created_at', Carbon::parse($this->moisSelectionne)->month)
                        ->latest()
                    ->with('produits');
            },
            'commandes' => function($query){
                $query->whereYear('created_at', Carbon::parse($this->moisSelectionne)->year)
                        ->whereMonth('created_at', Carbon::parse($this->moisSelectionne)->month)
                        ->latest()
                    ->with('produits');
            },
            'installations' => function($query) {
                $query->whereYear('created_at', Carbon::parse($this->moisSelectionne)->year)
                        ->whereMonth('created_at', Carbon::parse($this->moisSelectionne)->month)
                        ->latest()
                    ->with('produits');
            }
        ])->get();

        //classer les clients par montant total les plus eleve
        $this->clients = $this->clients->sortByDesc(function($client) {
            $totalVente = 0;
            foreach ($client->ventes as $vente) {
                foreach ($vente->produits as $produit) {
                    $totalVente += $produit->pivot->price * $produit->pivot->quantity;
                }
            }

            $totalInstallation = 0;
            foreach ($client->installations as $installation) {
                foreach ($installation->produits as $produit) {
                    $totalInstallation += $produit->pivot->price * $produit->pivot->quantity;
                }
            }

            return $totalVente + $totalInstallation;
        });
    }

    public function mount($moi)
    {
        $this->moisSelectionne = $moi;
        $this->afficher();
    }


    public function render()
    {
        return view('livewire.bilan-classement-client');
    }
}
