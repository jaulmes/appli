<?php

namespace App\Livewire;

use App\Models\Categori;
use Livewire\Component;
use Livewire\WithPagination;

class FrontEndCategoriProductView extends Component
{
    public $categoris;
    public $categoriId;
    use WithPagination;

    public function detailCategori(){

    }

    public function mount(){
        $this->categoris = Categori::inRandomOrder()->take(9)->get();
    }

    public function render()
    {
        return view('livewire.front-end-categori-product-view');
    }
}
