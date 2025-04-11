<?php

namespace App\Livewire;

use App\Models\commande;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BackendNavbar extends Component
{
    public $commandesNonLue;
    public $nombreCommandesNonLue;

    public $listeners = [
        'commandeMarqueLue' => 'mount',
        
    ];

    public function mount(){
        //afficher les le nombre de commande non lue
        $this->nombreCommandesNonLue = DB::table('commandes')->where('status', 0)->count();

        //afficher les commandes non lue
        $this->commandesNonLue = DB::table('commandes')->where('status', 0)->get();
        
    }
    public function render()
    {
        return view('livewire.backend-navbar');
    }
}
