<?php

namespace App\Livewire;

use App\Models\Charge;
use App\Models\Client;
use App\Models\Compte;
use App\Models\facture;
use App\Models\Installation;
use App\Models\Pack;
use App\Models\Produit;
use App\Models\Transaction;
use App\Models\Vente;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

use function React\Promise\all;

class ModalPackVenteEtInstallation extends Component
{
    public $cart = [], $formulaire_affiche, 
    $clients = [], $client_id, $comptes = [], 
    $nouveau_client = 'false', $nom_client, $numero_client,
    $adresse_client, $email_client, $montant_verse,
    $reduction, $mode_paiement, $commission, $impot,
    $agent_operant, $dateLimitePaiement, $frais_installation;

    protected $listeners = [
        'ajouter_pack_panier' => 'panierTotal',
        'prix_modifie' => 'panierTotal',
        'quantite_modifie' => 'panierTotal',
    ];

    public function panierTotal(){
        $this->cart = session()->get('parnier_pack', []);
        $total = 0;
        foreach ($this->cart as $item) {
            $total += $item['prix'] * $item['quantity'];
        }
        return $total;
    }

    public function toggleFormulaire()
    {
        if(isset($this->formulaire_affiche)){
            if($this->formulaire_affiche == "vente"){
                $this->formulaire_affiche = "vente";
            }else{
                $this->formulaire_affiche = "installation";
            }
        }
    }

    public function toggleClientForm(){
        if($this->nouveau_client == 'false'){
            $this->nouveau_client = 'true';
        }else{
            $this->nouveau_client = 'false';
        }
    }

    //enregistrer la vente d'un pack
    public function enregistrer_vente(){
        $parnier_pack = session()->get('parnier_pack', []);
        $totalAchat = 0;

        //totaliser le prix d'achat des produits
        foreach($parnier_pack as $item){
            foreach($item['produits'] as $produit){
                $totalAchat = $totalAchat + ($produit->prix_achat * $item['quantity']);
            }
        }

        $ventes = new Vente();
        if($this->nouveau_client == 'true'){
            if(!$this->client_id){
                $client = new Client();
                $client->nom = $this->nom_client;
                $client->numero = $this->numero_client;
                $client->adresse = $this->adresse_client;
                $client->email = $this->email_client;
                $client->save();
                $ventes->client_id = $client->id;
            }
        }else{
            if($this->client_id){
                $client = Client::find($this->client_id);
                $ventes->client_id = $this->client_id;
            }else{
                return redirect()->back()->with('error', 'veillez selectionner un client');
            }
        }
        $ventes->montantVerse = $this->montant_verse;
        $ventes->reduction = $this->reduction;

        //mise a jours du compte
        $comptes = Compte::find($this->mode_paiement);
        if($comptes){
            $comptes->montant = $comptes->montant + $this->montant_verse;
            $comptes->save();
            $ventes->compte_id = $this->mode_paiement;
        }else{
            return redirect()->back()->with('error', 'veillez selectionner un compte');
        }
    
        $ventes->agentOperant = $this->agent_operant;
        $ventes->commission = $this->commission;
        if($this->commission){
            $charges = new Charge();
            $charges->titre = "commission pour la vente du pack de ". $client->nom. " a ". $ventes->agentOperant; 
            $charges->montant = $charges->commission;
            $charges->save(); 
        }
        $ventes->montantTotal = $this->panierTotal();
        $ventes->totalAchat = $totalAchat;
        $ventes->netAPayer = $this->panierTotal() - $this->reduction;
        $ventes->montantVerse = $this->montant_verse;
        if($ventes->netAPayer > $ventes->montantVerse ){
            $ventes->statut = 'non termine';
            $ventes->dateLimitePaiement = $this->dateLimitePaiement;
        }else{
            $ventes->statut = 'termine';
        }
        $ventes->impot = $this->impot;
        $ventes->user_id = Auth::user()->id;

        $ventes->save();

        //mise a jour des stock
        foreach($parnier_pack as $item){
            foreach($item['produits'] as $produit){
                $produit_selectionne = Produit::find($produit->id);
                if($produit_selectionne->stock <= 0){
                    return redirect()->with('error', 'le stock du produit: '.$produit->name.' est épuisé');
                }
                if($item['quantity'] > $produit_selectionne->stock){
                    return redirect()->with('error', 'le stock du produit: '.$produit->name.' est insuffisant');
                }
                $produit_selectionne->stock = $produit_selectionne->stock - $item['quantity'];
                $produit_selectionne->save();
            }

            //je relie chaque panier a la vente
            $ventes->packs()->attach($item['id'], [
                'quantity' => $item['quantity'],
                'prix' => $item['prix'],
            ]); 
        }

        //j'enregistre dans le journal
        $transaction = new Transaction();
        $transaction->vente_id = $ventes->id;
        $transaction->type = 'vente de pack';
        $transaction->save();

        //j'enregistre la facture
        $facture = new facture();

        $facture->vente_id = $ventes->id;
        $numero = Vente::whereDate('created_at', now())->count() + 1;
        $numeroFacture = substr($client->nom, 0, 3).'_'.now()->format('y').'_'.now()->format('m').'_'.now()->format('d').'_'.$numero;
        $facture->numeroFacture = $numeroFacture;

        $facture->save();

        // Générer le PDF de la vente
        $pdf = Pdf::loadView('factures.afficherFactureVentePacks', [
            'ventes' => $ventes,
            'factures' => $facture,
        ]);
        $this->reset();
        return response()->streamDownload(function () use($pdf) {
            echo  $pdf->output();
        }, $numeroFacture.'-'.$client->numero.'.pdf');
    }

    public function enregistrer_installation(){
        $parnier_pack = session()->get('parnier_pack', []);
        //dd(count($parnier_pack));
        $totalAchat = 0;

        //totaliser le prix d'achat des produits
        foreach($parnier_pack as $item){
            foreach($item['produits'] as $produit){
                $totalAchat = $totalAchat + ($produit->prix_achat * $item['quantity']);
            }
        }

        $installations = new Installation();
        if($this->nouveau_client == 'true'){
            if(!$this->client_id){
                $client = new Client();
                $client->nom = $this->nom_client;
                $client->numero = $this->numero_client;
                $client->adresse = $this->adresse_client;
                $client->email = $this->email_client;
                $client->save();
                $installations->client_id = $client->id;
            }
        }else{
            if($this->client_id){
                $client = Client::find($this->client_id);
                $installations->client_id = $this->client_id;
            }else{
                return redirect()->back()->with('error', 'veillez selectionner un client');
            }
        }
        $installations->reduction = $this->reduction;

        //mise a jours du compte
        $comptes = Compte::find($this->mode_paiement);
        if($comptes){
            $comptes->montant = $comptes->montant + $this->montant_verse;
            $comptes->save();
            $installations->compte_id = $this->mode_paiement;
        }else{
            return redirect()->back()->with('error', 'veillez selectionner un compte');
        }
    
        $installations->mainOeuvre = $this->frais_installation;
        $installations->agentOperant = $this->agent_operant;
        $installations->commission = $this->commission;
        $installations->qteTotal = count($parnier_pack);
        if($this->commission){
            $charges = new Charge();
            $charges->titre = "commission pour la vente du pack de ". $client->nom. " a ". $installations->agentOperant; 
            $charges->montant = $charges->commission;
            $charges->save(); 
        }
        $installations->montantProduit = $this->panierTotal();
        $installations->totalAchat = $totalAchat;
        $installations->netAPayer = $this->panierTotal() - $this->reduction + $this->frais_installation;
        $installations->montantVerse = $this->montant_verse;
        if($installations->netAPayer > $installations->montantVerse ){
            $installations->statut = 'non termine';
            $installations->dateLimitePaiement = $this->dateLimitePaiement;
        }else{
            $installations->statut = 'termine';
        }
        $installations->impot = $this->impot;
        $installations->user_id = Auth::user()->id;

        $installations->save();

        //mise a jour des stock
        foreach($parnier_pack as $item){
            foreach($item['produits'] as $produit){
                $produit_selectionne = Produit::find($produit->id);
                if($produit_selectionne->stock <= 0){
                    return redirect()->with('error', 'le stock du produit: '.$produit->name.' est épuisé');
                }
                if($item['quantity'] > $produit_selectionne->stock){
                    return redirect()->with('error', 'le stock du produit: '.$produit->name.' est insuffisant');
                }
                $produit_selectionne->stock = $produit_selectionne->stock - $item['quantity'];
                $produit_selectionne->save();
            }

            //je relie chaque panier a la vente
            $installations->packs()->attach($item['id'], [
                'quantity' => $item['quantity'],
                'prix' => $item['prix'],
            ]); 
        }

        //j'enregistre dans le journal
        $transaction = new Transaction();
        $transaction->installation_id = $installations->id;
        $transaction->type = 'installation de pack';
        $transaction->save();

        //j'enregistre la facture
        $facture = new facture();

        $facture->installation_id = $installations->id;
        $numero = Installation::whereDate('created_at', now())->count() + 1;
        $numeroFacture = substr($client->nom, 0, 3).'_'.now()->format('y').'_'.now()->format('m').'_'.now()->format('d').'_'.$numero;
        $facture->numeroFacture = $numeroFacture;

        $facture->save();

        // Générer le PDF de la vente
        $pdf = Pdf::loadView('factures.afficherFactureInstallationPacks', [
            'installations' => $installations,
            'factures' => $facture,
        ]);
        $this->reset();
        return response()->streamDownload(function () use($pdf) {
            echo  $pdf->output();
        }, $numeroFacture.'-'.$client->numero.'.pdf');
    }

    public function mount(){
        $this->clients = Client::all();
        $this->comptes = Compte::all();
    }

    public function render()
    {
        return view('livewire.modal-pack-vente-et-installation');
    }
}
