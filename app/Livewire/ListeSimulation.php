<?php

namespace App\Livewire;

use App\Models\Simulation;
use App\Models\Simuleur;
use Livewire\Component;

class ListeSimulation extends Component
{
    public $simulations = [], $simuleurs;

    public function mount(){
        $this->simuleurs = Simuleur::all();
        $this->simulations = Simulation::orderBy('created_at', 'desc')
                                        ->get();
    }
    public function render()
    {
        return view('livewire.liste-simulation');
    }
}
