<?php

namespace App\Livewire;

use App\Models\BonCommande;
use App\Models\Compte;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ModalValiderBonCommandes extends Component
{
    public $comptes;

    public function enregistrerBonCommande(){

        $cart = session()->get('cart', []);
        dd($cart);
        $bonCommandes =  new BonCommande();
        $bonCommandes->compte_id = $this->compte_id;
        $bonCommandes->montant = $this->montant;
        $bonCommandes->titre = $this->titre;
        $bonCommandes->user_id = Auth::user()->id;
        $bonCommandes->save();

        foreach($cart as $produit){
            $bonCommandes->produits()->attach($produit['id'], [
                'quantite' => $produit['quantite'],
                'prix' => $produit['prix'],
            ]);
        }

        
    }

    public function mount(){
        $this->comptes = Compte::all();
    }

    public function render()
    {
        return view('livewire.modal-valider-bon-commandes');
    }
}
