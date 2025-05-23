<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\commande;
use App\Models\Compte;
use App\Models\facture;
use App\Models\Produit;
use App\Models\Transaction;
use App\Models\Vente;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ModalValiderCommande extends Component
{
    public $comptes;
    public $compte_id;
    public $reduction;
    public $montantVerse;
    public $dateLimitePaiement;
    public $commandeId;

    public function validerCommande(){
        //recuperer la commande
        $commande = commande::find($this->commandeId);
        $clients = Client::find($commande->client_id);
        $panier = $commande->produits;
        $panier_pack = $commande->packs;


        
        $commande->validation = 1;
        $commande->status = 1;
        $commande->user_id = Auth::user()->id;
        $commande->save();

        //creer une nouvelle instance de vente
        $ventes = new Vente();

        $montantTotal = 0;
        $totalAchat = 0;
        //total achat des produit
        if($commande->produits){
            foreach($commande->produits as $produit){
                $montantTotal += $produit->pivot->price * $produit->pivot->quantity;
                $totalAchat += $produit->prix_achat * $produit->pivot->quantity;
                $produit->stock -= $produit->pivot->quantity;

                $produit->save();
            }
        }
        //total achat des produits du pack
        if($commande->packs){
            foreach($commande->packs as $pack){
                $montantTotal += $pack->pivot->prix * $pack->pivot->quantity;
                foreach($pack->produits as $produit){
                    $totalAchat += $produit->prix_achat * $produit->pivot->quantity;
                    $produit->stock -= $produit->pivot->quantity;

                    $produit->save();
                }
            }
        }

        $ventes->montantTotal = $montantTotal;
        $ventes->reduction = $this->reduction;
        $ventes->NetAPayer = $montantTotal - $this->reduction;
        $ventes->montantVerse = $this->montantVerse;
        $ventes->totalAchat = $totalAchat;
        $ventes->compte_id = $this->compte_id;
        $ventes->user_id = Auth::user()->id;
        $ventes->commande_id = $commande->id;
        $ventes->dateLimitePaiement = $this->dateLimitePaiement;
        $ventes->save();

        //mettre a jour le compte
        $compte = Compte::find($this->compte_id);
        //dd($this->compte_id, $compte);
        $compte->montant = $compte->montant + $this->montantVerse;
        $compte->save();

        //enregistrer dans les transactions
        $transaction = new Transaction();
        $transaction->type = 'validation commande';
        $transaction->commande_id = $commande->id;
        $transaction->save();

        //je relie chaque produit de la commande a la vente 
        foreach($panier as $produit){
            $ventes->produits()->attach($produit->id, [
                'quantity' => $produit->pivot->quantity,
                'price' => $produit->pivot->price,
                'vente_id'=>$ventes->id
            ]);
        }

                //je relie chaque produit de la commande a la vente 
        foreach($panier_pack as $pack){
            $ventes->packs()->attach($pack->id, [
                'quantity' => $pack->pivot->quantity,
                'price' => $pack->pivot->prix,
                'vente_id'=>$ventes->id
            ]);
        }

        //creer une facture pour enregistrer dans le systeme
        $factures = new facture();

        //compter le nombre de vente pour incrementer le numero de la facture
        $numero =Vente::where('date', $ventes->date )->get()->count() + 1;
        $name = Auth::user()->name;
        //j'enregistre le numero de la facture sous la forme : nom_annee_mois_jour_numero
        $numeroFacture = substr($name, 0, 3).'_'.date('Y').'_'.date('m').'_'.date('d').'_'. $numero;
        $factures->numeroFacture = $numeroFacture;
        $factures->vente_id = $ventes->id;
        $factures->save();

        return redirect()->route('commandes.index')->with('message', 'Commande validée avec succès. retrouvez la facture dans la rubrique facture');
    }

    public function mount($commandeId){
        $this->commandeId = $commandeId;
        $this->comptes = Compte::all();
    }

    public function render()
    {
        return view('livewire.modal-valider-commande');
    }
}
