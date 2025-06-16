<?php

namespace App\Livewire;

use App\Models\BonCommande;
use Livewire\Component;

class ListeBonCommande extends Component
{
    public $bonCommandes;
    public $search = '';

    public function updateBon($id){
        $bon = BonCommande::find($id);
        dd($bon);
    }

    public function mount()
    {
        $this->bonCommandes = BonCommande::with('comptes', 'users')
            ->where('titre', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    public function render()
    {
        return view('livewire.liste-bon-commande');
    }
}
