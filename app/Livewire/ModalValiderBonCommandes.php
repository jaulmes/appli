<?php

namespace App\Livewire;

use App\Models\BonCommande;
use App\Models\Compte;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ModalValiderBonCommandes extends Component
{
    public $comptes, $compte_id, $montant, $titre, 
            $date_livraison, $date_commande, $frais, $cart ;
    
    protected $listeners = [
        'ProduitAjoute' => 'updateCart',
        'ProduitAjoute' => '$refresh',
        'panierVide' => '$refresh',
        'panierVide' => 'mount',
        'prix_change' => 'mount',
    ];

    public function updateCart(){
        $total = 0; 
        $this->cart = session()->get('cart', []);
        foreach($this->cart as $produit){
            $total += $produit['prix_achat'] * $produit['quantity'];
        }
        return $total;
    }

    public function enregistrerBonCommande(){

        $this->cart = session()->get('cart', []);
        if (empty($this->cart)) {
            session()->flash('error', 'Le panier est vide.');
            return;
        }
        $comptes = Compte::find($this->compte_id);

        //dd($cart);
        $bonCommandes =  new BonCommande();
        $transactions = new Transaction();

        $bonCommandes->compte_id = $this->compte_id;
        $bonCommandes->montant = $this->montant;
        $bonCommandes->titre = $this->titre;
        $bonCommandes->user_id = Auth::user()->id;
        $bonCommandes->date_livraison = $this->date_livraison;
        $bonCommandes->date_commande = $this->date_commande;
        $bonCommandes->status = 'En attente';
        $bonCommandes->frais = $this->frais;
        $comptes->montant = $comptes->montant - $bonCommandes->montant - $this->frais;

        $bonCommandes->save();
        $transactions->user_id = Auth::user()->id;
        $transactions->type = 'BonCommande';
        $transactions->compte_id = $this->compte_id;
        $transactions->bon_commande_id = $bonCommandes->id;
        foreach($this->cart as $produit){
            $bonCommandes->produits()->attach($produit['id'], [
                'quantity' => $produit['quantity'],
                'price' => $produit['price'],
            ]);
        }
        $transactions->save();
        $comptes->save();

        session()->flash('success', 'Bon de commande enregistré avec succès.');
        session()->forget('cart'); // Vider le panier après l'enregistrement
        return redirect()->route('bonCommandes.index');

        
    }

    public function mount(){
        $this->cart = session()->get('cart', []);
        //calculr du total du panier
        $this->montant = 0; // Réinitialiser le montant
        foreach($this->cart as $produit){
            $this->montant += $produit['prix_achat'] * $produit['quantity'];
        }
        $this->comptes = Compte::all();
    }

    public function render()
    {
        return view('livewire.modal-valider-bon-commandes');
    }
}
