<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Compte;
use App\Models\Installation as ModelsInstallation;
use Livewire\Component;

class Installation extends Component
{
    public $installations = [];
    public $query;
    public $clients = [];
    public $comptes = [];

    public function mount(){
        $this->installations = ModelsInstallation::orderBy('created_at', 'desc')
                                                   ->get();
        $this->clients = Client::all();
        $this->comptes = Compte::all();
    }

    //ajouter un paiement

    //recherche
    public function update_search(){
        $this->installations = ModelsInstallation::where('nomClient', 'like', '%'. $this->query .'%')
                                                   ->orWhere('numeroClient', 'like', '%'. $this->query .'%')
                                                   ->get();
    }
    public function render()
    {
        return view('livewire.installation');
    }
}
