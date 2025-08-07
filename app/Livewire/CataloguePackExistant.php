<?php

namespace App\Livewire;

use App\Models\Categori;
use App\Models\Pack;
use App\Models\Produit;
use Livewire\Component;

class CataloguePackExistant extends Component
{
    public $packs, $query;

    public function addToCart($packId)
    {
        $cart = session()->get('parnier_pack', []);

        $produits = Pack::find($packId)->produits;

        foreach($produits as $produit){
            $produitId = $produit->id;

            if (!isset($cart[$produitId])) {
                $cart[$produitId] = [
                    'quantity' => 1,
                    'id' => $produit->id,
                    'name' => $produit->name,
                    'price' => $produit->price,
                    'prix_catalogue' => $produit->price,
                    'prix_technicien' => $produit->prix_technicien,
                    'prix_minimum' => $produit->prix_minimum,
                    'prix_achat' => $produit->prix_achat,
                    'prix_promo' => $produit->prix_promo,
                ];
                
            } else {
                $cart[$produitId]['quantity']++;
            }
            $panier = session()->get('panier_pack', $cart);
            //dd($panier);
            $this->dispatch('ajouter_pack_panier');
            session()->put('parnier_pack', $cart);
        }

        //dd($cart);

        // if (isset($cart[$packId])) {
        //     $cart[$packId]['quantity']++;
        // } else {
        //     $cart[$packId] = [
        //         "id" => $packId,
        //         "image" => $this->packs->find($packId)->image,
        //         "titre" => $this->packs->find($packId)->titre,
        //         "prix" => $this->packs->find($packId)->prix,
        //         "quantity" => 1,
        //         "produits" => $this->packs->find($packId)->produits,
        //     ];
        // }

        // $this->dispatch('ajouter_pack_panier');
        // session()->put('parnier_pack', $cart);
        session()->flash('success', 'Produit ajouté au panier !');
    }

    public function update_query(){
        if (empty($this->query)) {
            $this->packs = Pack::all();
            return;
        }
        $this->packs = Pack::where('titre', 'like', '%'.$this->query.'%')
                            ->orWhere('description', 'like', '%'.$this->query.'%')
                            ->get();
    }

    public function mount()
    {
        $this->packs = Pack::all();
    }
    public function render()
    {
        return view('livewire.catalogue-pack-existant');
    }
}
