<?php

namespace App\Livewire;

use App\Models\Produit;
use Livewire\Component;

class FrontEndAffichargeProduitsAdmin extends Component
{

    public $produits  = [];
    public $query = '';

    public function toggleVisibility($produitId)
    {
        $produit = Produit::find($produitId);
        if ($produit) {
            $produit->is_website_visible = !$produit->is_website_visible;
            $produit->save();
            return redirect()->back()->with('message', 'Visibilité du produit mise à jour avec succès.');
        }
    }

    public function searchProduit(){
        $this->produits = Produit::where('name', 'like', '%' . $this->query . '%')
            ->orderBy('name', 'ASC')
            ->get();
    }

    public function mount()
    {
        $this->produits = Produit::orderBy('name', 'ASC')->get();
    }
    public function render()
    {
        return view('livewire.front-end-afficharge-produits-admin');
    }
}
