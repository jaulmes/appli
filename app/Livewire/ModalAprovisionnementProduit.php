<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Session;
use Livewire\Component;

class ModalAprovisionnementProduit extends Component
{
    
    public $cart;

    public function render()
    {
        return view('livewire.modal-aprovisionnement-produit');
    }
}
