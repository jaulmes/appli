<?php

namespace App\Livewire;

use App\Models\Categori;
use App\Models\Produit;
use Livewire\Component;

class FrontEndCategoriDetailView extends Component
{
    //public $produits;
    public $cart = [];
    public Categori $categori;
    public $produits = [];

    public function mount($id)
    {
        $this->categori = $id;
        dd($this->categoriId);
        $this->produits = Produit::where('categori_id', $id)->get();
    }

    public function render()
    {
        return view('livewire.front-end-categori-detail-view');
    }
}
