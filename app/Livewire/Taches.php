<?php

namespace App\Livewire;

use App\Models\Tache;
use Livewire\Component;

class Taches extends Component
{
    public $taches = [];

    protected $listeners = ['tacheAjoute', 'updateTache'];
    public function mount(){
        $this->taches = Tache::all();
    }

    public function updateTache(){
        $this->taches;
    }
    
    public function render()
    {
        return view('livewire.taches');
    }
}
