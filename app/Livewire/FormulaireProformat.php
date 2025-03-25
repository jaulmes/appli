<?php

namespace App\Livewire;

use App\Models\Client;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class FormulaireProformat extends Component
{
    public $clients;
    public $cartContent;

    public function montantTotal(){
        $this->cartContent = Session::get('cart', []);
        $total = 0;
        foreach($this->cartContent as $item){
            $total = $total + $item['quantity'] * $item['price'];
        }
        return $total;
    }

    public function mount(){
        $this->clients = Client::all();
    }

    public function render()
    {
        return view('livewire.formulaire-proformat');
    }
}
