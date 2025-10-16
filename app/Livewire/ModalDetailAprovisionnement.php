<?php

namespace App\Livewire;

use Livewire\Component;

class ModalDetailAprovisionnement extends Component
{
    public $achat;
    public function mount($achat){
        $this->achat = $achat;
    }
    public function render()
    {
        return view('livewire.modal-detail-aprovisionnement');
    }
}
