<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Compte;
use App\Models\Recu;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Recus extends Component
{
    public  $recus = [];
    public $clients;
    public $comptes;
    public $motif;
    public $montant;
    public $client_id;
    public $compte_id;

    public function creerRecu(){ 
        $recus = new Recu();
        $recus->numero_recu = '';
        $recus->compte_id = $this->compte_id;
        $recus->remarque = $this->motif;
        $recus->user_id = Auth::user()->id;
        $recus->client_id = $this->client_id;
        $recus->montant_recu = $this->montant;
    }
    public function mount(){
        $this->recus = Recu::with('clients')
                                ->orderBy('created_at', 'asc')
                                ->get();
        
        $this->clients = Client::all();
        $this->comptes = Compte::all();
    }
    
    public function render()
    {
        return view('livewire.recus');
    }
}
