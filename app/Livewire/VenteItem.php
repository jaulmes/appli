<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Compte;
use App\Models\Vente;
use Livewire\Component;

class VenteItem extends Component
{
    public $vente;
    public $clients;
    public $comptes;
    public function mount(Vente $vente)
    {
        $this->vente = $vente;
        $this->clients = Client::all();
        $this->comptes = Compte::all();

    }
    public function render()
    {
        return view('livewire.vente-item');
    }
}
