<?php

namespace App\Livewire;

use App\Models\Categori;
use Livewire\Component;
use Livewire\WithPagination;

class FrontEndCategoriProductView extends Component
{
    public $categoris;
    use WithPagination;

    public function mount(){
        $this->categoris = Categori::inRandomOrder()->take(10)->get();
    }

    public function render()
    {
        return view('livewire.front-end-categori-product-view');
    }
}
