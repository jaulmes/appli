<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Session;
use Livewire\Component;

class ModalProformat extends Component
{

    public function montantTotal(){
        $total = 0;
        foreach(Session::get('cart', []) as $item){
            $total = $total + $item['quantity'] * $item['price'];
        }
        return $total;
    }

    public function render()
    {
        return view('livewire.modal-proformat');
    }
}
