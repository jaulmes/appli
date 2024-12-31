<?php

namespace App\Livewire;

use App\Models\Installation as ModelsInstallation;
use Livewire\Component;

class Installation extends Component
{
    public $installations = [];
    public $query;

    public function mount(){
        $this->installations = ModelsInstallation::all();
    }

    //recherche
    public function update_search(){
        $this->installations = ModelsInstallation::where('nomClient', 'like', '%'. $this->query .'%')
                                                   ->orWhere('numeroClient', 'like', '%'. $this->query .'%')
                                                   ->get();
    }
    public function render()
    {
        return view('livewire.installation');
    }
}
