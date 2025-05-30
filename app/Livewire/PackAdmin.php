<?php

namespace App\Livewire;

use App\Models\Pack;
use Livewire\Component;

class PackAdmin extends Component
{
    public $packs = [];
    protected $listeners = [
        'supprimerPack' => 'mount'
    ];

    public function deletePack($id){
        $pack = Pack::find($id)->delete();
        $this->dispatch('supprimerPack');
    }

    public function mount(){
        $this->packs = Pack::all();
    }
    public function render()
    {
        return view('livewire.pack-admin');
    }
}
