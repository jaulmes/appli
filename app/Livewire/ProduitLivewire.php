<?php

namespace App\Livewire;

use App\Models\Produit;
use Livewire\Component;

class ProduitLivewire extends Component
{
    public $produits = []; 
    public $query ='';

    public function rechercher_produit(){

        $this->produits = Produit::where('name', 'like', '%' . $this->query . '%')
                                ->orWhere('description', 'like', '%' . $this->query . '%')
                                    ->get();
    }


    public function mount(){
        $this->produits = Produit::all();

    }
    
    public function render()
    {
        return view('livewire.produit-livewire');
    }
}
