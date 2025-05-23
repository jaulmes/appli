<?php

namespace App\Livewire;

use App\Models\commande;
use Livewire\Component;

class Commandes extends Component
{
    public $commandes;
    public $newCommandeCount;
    public $nouvelleCommande;

    public $listeners = [
        'commandeMarqueLue' => '$refresh',
    ];

    public function compteurNouvelleCommande(){
        $this->newCommandeCount = commande::where('status', 0)->count();
    }

    public function NewCommandes(){
        $this->nouvelleCommande = commande::where('status', 0)->get();
    }

    public function marquerCommeLue($id){
        $commande = commande::find($id);
        $commande->status = 1;
        $commande->save();

        $this->dispatch('commandeMarqueLue');
    }

    public function mount()
    {
        //$this->nouvelleCommande = commande::where('status', 0)->get();
        $this->commandes = commande::orderBy('created_at', 'desc')->get();
    }

    public function render()
    {
        return view('livewire.commandes');
    }
}
