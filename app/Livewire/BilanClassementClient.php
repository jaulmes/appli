<?php

namespace App\Livewire;

use App\Models\Client;
use Livewire\Component;

class BilanClassementClient extends Component
{

    public $clients = [];

    public function mount(){
        $debutDuMois = now()->startOfMonth();
        $finDuMois = now()->endOfMonth();

        $this->clients = Client::with([
            'ventes' => function($query) use ($debutDuMois, $finDuMois) {
                $query->whereBetween('created_at', [$debutDuMois, $finDuMois])
                    ->with('produits');
            },
            'commandes' => function($query) use ($debutDuMois, $finDuMois) {
                $query->whereBetween('created_at', [$debutDuMois, $finDuMois])
                    ->with('produits');
            },
            'installations' => function($query) use ($debutDuMois, $finDuMois) {
                $query->whereBetween('created_at', [$debutDuMois, $finDuMois])
                    ->with('produits');
            }
        ])->get();

        //classer les clients par montant total les plus eleve
        $this->clients = $this->clients->sortByDesc(function($client) {
            return $client->ventes->sum('montantTotal') +
                   $client->commandes->sum('montantTotal') +
                   $client->installations->sum('montantTotal');
        });

        //$this->clients = Client::all();
    }
    public function render()
    {
        return view('livewire.bilan-classement-client');
    }
}
