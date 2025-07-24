<?php

namespace App\Livewire;

use App\Models\Compte;
use App\Models\facture;
use App\Models\Produit;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class Factures extends Component
{
    public $factures;
    public $type = 'ventes';

    public function mount(){
        $this->chargerFacture();
    }

    public function Ventes(){
        $this->type = "ventes";
        $this->chargerFacture();
    }

    public function Installations(){
        $this->type = "installations";
        $this->chargerFacture();
    }

    public function Proformats(){
        $this->type = "proformat";
        $this->chargerFacture();
    }

    public function chargerFacture(){
        
        if($this->type == "ventes"){
            $this->factures = facture::whereHas('ventes')
                                    ->with('ventes')
                                    ->orderBy('created_at', 'desc')
                                    ->get();
        }
        elseif($this->type == "installations"){
            $this->factures = facture::whereHas('installations')
            ->with('installations')
            ->orderBy('created_at', 'desc')
            ->get();
        }
        elseif($this->type == "proformat"){
            $this->factures = facture::whereHas('proformats')
            ->with('proformats')
            ->orderBy('created_at', 'desc')
            ->get();

        }
    }

    //logique pour la supression des factures
    public function supprimerFacture($id){

        $facture = facture::find($id);

        //factures des ventes
        if($this->type == "ventes")
        {
            $ventes = $facture->ventes;

            //je recuperes le compte lie a la vente
            $comptes = Compte::find($ventes->compte_id);

            //recuperation de chaque produits lie a la facture
            foreach ($ventes->produits as $produit) {
                //montant de chaque produit et sa quantite
                $montant_produit = $produit->pivot->price * $produit->pivot->quantity;
                //mise a jour du compte
                $comptes->montant = $comptes->montant - $montant_produit;

                //mise a jour du stock
                $produit->stock = $produit->stock + $produit->pivot->quantity;

                $comptes->save();
                $produit->save();
            }
            $ventes->delete();
        }
        elseif($this->type == "installations"){
            $installations = $facture->installations;

            //je recuperes le compte lie a la vente
            $comptes = Compte::find($installations->compte_id);

            //recuperation de chaque produits lie a la facture
            foreach ($installations->produits as $produit) {
                //montant de chaque produit et sa quantite
                $montant_produit = $produit->pivot->price * $produit->pivot->quantity;
                //mise a jour du compte
                $comptes->montant = $comptes->montant - $montant_produit;

                //mise a jour du stock
                $produit->stock = $produit->stock + $produit->pivot->quantity;

                $comptes->save();
                $produit->save();
            }
            $installations->delete();
        }

        $dateHeure = now();
        //enregistrer l'historique
        $transactions = new Transaction();
        $transactions->date = $dateHeure->format('d/m/y');
        $transactions->heure = $dateHeure->format('H:i:s');
        $transactions->type = "supression d'une facture";
        $transactions->user_id = Auth::user()->id;
        $transactions->save();

        $facture->delete();
        session()->flash("message", "vous venez de suprimer une facture");
        $this->chargerFacture();
    }

    public function render()
    {
        return view('livewire.factures');
    }
}
