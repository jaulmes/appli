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
use Illuminate\Support\Facades\DB;
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
        $this->cart = session()->get('cart', []);
        $total = 0;
        foreach ($this->cart as $produit) {
            $total += $produit['price'] * $produit['quantity'];
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
        try {
            DB::beginTransaction();
            $parnier_pack = session()->get('cart', []);
            $totalAchat = 0;

            //totaliser le prix d'achat des produits
            foreach($parnier_pack as $produit){
                $totalAchat = $totalAchat + ($produit['prix_achat'] * $produit['quantity']);
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
                    return redirect()->back()->with('error_html', 'veillez selectionner un client');
                }
            }
            
            $ventes->montantVerse = $this->montant_verse;
            $ventes->reduction = $this->reduction;

            //mise a jours du compte
            $comptes = Compte::find($this->mode_paiement);
            
        
            $ventes->agentOperant = $this->agent_operant;
            $ventes->commission = $this->commission;
            if($this->commission > 0){
                $charges = new Charge();
                $charges->titre = "commission pour la vente du pack de ". $client->nom. " a ". $ventes->agentOperant; 
                $charges->montant = $this->commission;
                $charges->save(); 
                if($comptes){
                    $comptes->montant = $comptes->montant + $this->montant_verse - $this->commission;
                    $comptes->save();
                    $ventes->compte_id = $this->mode_paiement;

                }else{
                    return redirect()->back()->with('error_html', 'veillez selectionner un compte');
                }
                
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

            //dd($ventes);
            $ventes->save();

            //mise a jour des stock
            foreach($parnier_pack as $produit){
                $produit_selectionne = Produit::find($produit['id']);
                if ($produit_selectionne->stock <= 0) {
                    $message = "<div class='d-flex justify-content-between align-items-start'>
                                    <div>
                                        Le stock du produit <strong>« {$produit['name']} »</strong> est épuisé.<br> 
                                        👉<a href='" . route('achats.cart') . "' target='_blank' class='text-decoration-underline text-primary'>
                                             Cliquez ici pour accéder au catalogue d'achat 
                                        </a>👈  dans un nouvel onglet.
                                        <br>Copier le titre du produit et le coller dans la barre de recherche du catalogue d'achat qui a été ouvert dans le nouvel onglet.
                                    </div>
                                    <button type='button' class='btn-close ms-3' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>";
                    return redirect()->back()->with('error_html', $message);
                }
                if($produit['quantity'] > $produit_selectionne->stock){
                    return redirect()->with('error_html', 'le stock du produit: '.$produit['name'].' est insuffisant');
                }
                $produit_selectionne->stock = $produit_selectionne->stock - $produit['quantity'];
                $produit_selectionne->save();

                //je relie chaque produit a la vente
                $ventes->produits()->attach($produit['id'], [
                    'quantity' => $produit['quantity'],
                    'price' => $produit['price'],
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
            DB::commit();
            
            return response()->streamDownload(function () use($pdf) {
                echo  $pdf->output();
            }, $numeroFacture.'-'.$client->numero.'.pdf');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error_html', 'Une erreur est survenue lors de l\'enregistrement de la vente : ' . $e->getMessage());
        }
    }

    public function enregistrer_installation()
    {
        try {
            DB::beginTransaction();
            $parnier_pack = session()->get('cart', []);
            $totalAchat = 0;

            // Calcul du total d'achat
            foreach ($parnier_pack as $produit) {
                $totalAchat += ($produit['prix_achat'] * $produit['quantity']);
            }

            $installations = new Installation();

            // Création ou sélection du client
            if ($this->nouveau_client == 'true') {
                if (!$this->client_id) {
                    $client = new Client();
                    $client->nom = $this->nom_client;
                    $client->numero = $this->numero_client;
                    $client->adresse = $this->adresse_client;
                    $client->email = $this->email_client;
                    $client->save();
                    $installations->client_id = $client->id;
                }
            } else {
                if ($this->client_id) {
                    $client = Client::find($this->client_id);
                    $installations->client_id = $client->id;
                } else {
                    return redirect()->back()->with('error_html', 'Veuillez sélectionner un client.');
                }
            }

            $installations->reduction = $this->reduction;
            $installations->mainOeuvre = $this->frais_installation;
            $installations->agentOperant = $this->agent_operant;
            $installations->commission = $this->commission;
            $installations->qteTotal = count($parnier_pack);

            // Mise à jour du compte
            $compte = Compte::find($this->mode_paiement);
            if ($this->commission > 0) {
                $charge = new Charge();
                $charge->titre = "Commission pour l'installation du pack de {$client->nom} par {Auth::user()->name}";
                $charge->montant = $this->commission;
                $charge->save();

                if ($compte) {
                    $compte->montant = $compte->montant + $this->montant_verse - $this->commission;
                    $compte->save();
                    $installations->compte_id = $this->mode_paiement;
                    $transactionCharge = new Transaction();
                    $transactionCharge->type = "charge";
                    $transactionCharge->montantVerse = $installations->commission;
                    $transactionCharge->compte_id = $compte->id;
                    $transactionCharge->user_id = Auth::user()->id;
                    $transactionCharge->save();
                } else {
                    return redirect()->back()->with('error_html', 'Veuillez sélectionner un compte.');
                }
            }

            $installations->montantProduit = $this->panierTotal();
            $installations->totalAchat = $totalAchat;
            $installations->netAPayer = $this->panierTotal() - $this->reduction + $this->frais_installation;
            $installations->montantVerse = $this->montant_verse;

            $installations->statut = $installations->netAPayer > $this->montant_verse ? 'non termine' : 'termine';
            if ($installations->statut == 'non termine') {
                $installations->dateLimitePaiement = $this->dateLimitePaiement;
            }

            $installations->impot = $this->impot;
            $installations->user_id = Auth::id();
            $installations->save();

            // Mise à jour des stocks et rattachement des packs
            foreach ($parnier_pack as $produit) {
                $produit_selectionne = Produit::find($produit['id']);

                if ($produit_selectionne->stock <= 0) {
                    $message = "<div class='d-flex justify-content-between align-items-start'>
                                    <div>
                                        Le stock du produit <strong>« {$produit['name']} »</strong> est épuisé.<br> 
                                        👉<a href='" . route('achats.cart') . "' target='_blank' class='text-decoration-underline text-primary'>
                                            Cliquez ici pour accéder au catalogue d'achat 
                                        </a>👈  dans un nouvel onglet.
                                        <br>Copiez le titre du produit et collez-le dans la barre de recherche du catalogue d'achat.
                                    </div>
                                    <button type='button' class='btn-close ms-3' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>";
                    return redirect()->back()->with('error_html', $message);
                }

                if ($produit['quantity'] > $produit_selectionne->stock) {
                    return redirect()->with('error_html', 'Le stock du produit : ' . $produit->name . ' est insuffisant.');
                }

                $produit_selectionne->stock -= $produit['quantity'];
                $produit_selectionne->save();
                

                $installations->produits()->attach($produit['id'], [
                    'quantity' => $produit['quantity'],
                    'price' => $produit['price'],
                ]);
            }

            // Enregistrement dans le journal
            $transaction = new Transaction();
            $transaction->installation_id = $installations->id;
            $transaction->type = 'installation de pack';
            $transaction->save();

            // Génération de la facture
            $facture = new Facture();
            $facture->installation_id = $installations->id;
            $numero = Installation::whereDate('created_at', now())->count() + 1;
            $numeroFacture = substr($client->nom, 0, 3) . '_' . now()->format('y_m_d') . '_' . $numero;
            $facture->numeroFacture = $numeroFacture;
            $facture->save();

            // Génération PDF
            $pdf = Pdf::loadView('factures.afficherFactureInstallationPacks', [
                'installations' => $installations,
                'factures' => $facture,
            ]);

            $this->reset();
            DB::commit();

            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->output();
            }, $numeroFacture . '-' . $client->numero . '.pdf');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error_html', 'Une erreur est survenue lors de l\'enregistrement de l\'installation : ' . $e->getMessage());
        }
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
