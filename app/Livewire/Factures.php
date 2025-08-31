<?php

namespace App\Livewire;

use App\Models\Compte;
use App\Models\facture;
use App\Models\Produit;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class Factures extends Component
{

    public $listeners = ['factureSupprimee' => 'refresh',
                        'factureSupprimee' => 'chargerFacture'];
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
public function supprimerFacture($id)
{
    DB::beginTransaction();
    try {
        $facture = Facture::findOrFail($id);
        
        if ($this->type === "ventes") {
            $vente = $facture->ventes;
            $transaction = Transaction::where('vente_id', $vente->id)
                                        ->with('produits')
                                        ->first();
            
            if (isset($vente)) {
                $compte = Compte::find($vente->compte_id);

                foreach ($vente->produits as $produit) {
                    $montant_produit = $produit->pivot->price * $produit->pivot->quantity;

                    // Mise à jour du compte
                    if ($compte) {
                        $compte->montant -= $montant_produit;
                        $compte->save();
                    }

                    // Mise à jour du stock
                    $produit->stock += $produit->pivot->quantity;
                    $produit->save();
                    $transaction->produits()->detach($produit->id);
                }
                //$vente->produits()->detach();
                $facture->delete();
                $vente->delete();
                
            }else{
                session()->flash("error", "Cette facture de vente n'existe pas.");
                return;
            }
        } elseif ($this->type === "installations") {

            $installation = $facture->installations;
            $transaction = Transaction::where('installation_id', $installation->id)
                            ->with('produits')
                            ->first();
            
            if (isset($installation)) {
                $compte = Compte::find($installation->compte_id);

                foreach ($installation->produits as $produit) {
                    $montant_produit = $produit->pivot->price * $produit->pivot->quantity;

                    // Mise à jour du compte
                    if ($compte) {
                        $compte->montant -= $montant_produit;
                        $compte->save();
                    }

                    // Mise à jour du stock
                    $produit->stock += $produit->pivot->quantity;
                    $produit->save();
                    $transaction->produits()->detach($produit->id);

                }
                $facture->delete();
                $installation->delete();
            }else{
                session()->flash("error", "Cette facture d'installation n'existe pas.");
                return;
            }
        }

        // Historique
        $dateHeure = now();
        $transaction = new Transaction();
        $transaction->date = $dateHeure->format('d/m/y');
        $transaction->heure = $dateHeure->format('H:i:s');
        $transaction->type = "suppression d'une facture";
        $transaction->user_id = Auth::id();
        $transaction->save();

        DB::commit();
        session()->flash("message", "Vous venez de supprimer une facture");
        //$this->chargerFacture();
        $this->dispatch('factureSupprimee');
        return redirect()->route('factures.ventes');

    } catch (\Exception $e) {
        DB::rollBack();
        session()->flash("error", "Erreur lors de la suppression de la facture : " . $e->getMessage());
    }
}


    public function render()
    {
        return view('livewire.factures');
    }
}
