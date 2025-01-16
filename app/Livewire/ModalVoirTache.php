<?php

namespace App\Livewire;

use App\Models\Tache;
use Livewire\Component;

class ModalVoirTache extends Component
{
    public $tache;

    public function mount(Tache $tache){
        $this->tache = $tache;
    }
    public function render()
    {
        return view('livewire.modal-voir-tache');
    }
}
