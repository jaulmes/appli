<?php

namespace App\Livewire;

use App\Models\FrontentPresentation;
use Livewire\Component;

class FrontEndPresentationView extends Component
{
    public $presentations;

    public function mount(){
        $this->presentations = FrontentPresentation::all();
    }
    public function render()
    {
        return view('livewire.front-end-presentation-view');
    }
}
