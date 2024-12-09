<?php

namespace App\Livewire;

use App\Models\Produit;
use Illuminate\Http\Request;
use Livewire\Component;

class FiltreProduit extends Component
{



    public function render(Request $request)
    {
        $search = $request->search;
        $produits = Produit::where('name', 'like', "%$search%")
                            ->orWhere('description', 'like', "%$search%")
                            ->get();
        return view('livewire.filtre-produit', compact('produits'));
    }
}
