<?php

namespace App\Livewire;

use App\Models\Categori;
use App\Models\Produit;
use App\Models\Realisation;
use App\Models\Service;
use Livewire\Component;

class FrontEndSearchBar extends Component
{
    public $query = '';
    public $results = [];

    protected $listeners = ['search' => 'performSearch'];

    public function rechercher()
    {
        $this->results = [];

        if ($this->query){
            $products = Produit::where('name', 'like', '%' . $this->query . '%')->get();
            $services = Service::where('name', 'like', '%' . $this->query . '%')->get();
            $realisations = Realisation::where('titre', 'like', '%' . $this->query . '%')->get();
            $categories = Categori::where('titre', 'like', '%' . $this->query . '%')->get();

            $this->results = [
                'Produits' => $products,
                'Services' => $services,
                'Réalisations' => $realisations,
                'Catégories' => $categories,
            ];

        }
    }

    public function annuler()
    {
        $this->query = '';
        $this->results = [];
    }

    public function render()
    {
        return view('livewire.front-end-search-bar');
    }
}
