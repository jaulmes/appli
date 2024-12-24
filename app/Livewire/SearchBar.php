<?php

namespace App\Livewire;

use Illuminate\Http\Request;
use Livewire\Component;

class SearchBar extends Component
{
    public $query ='';
    public function updatedQuery(){
        $word = '%' . $this->query . '%';
        $this->dispatch('produitRecherche', $word);
    }
    public function render()
    {
        return view('livewire.search-bar');
    }
}
