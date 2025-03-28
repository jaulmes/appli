<?php

namespace App\Livewire;

use App\Models\Realisation;
use Livewire\Component;

class FrontEndRealisationView extends Component
{
    public $realisations;

    public function mount(){
        $this->realisations = Realisation::all();
    }
    public 
    function render()
    {
        return view('livewire.front-end-realisation-view');
    }
}
