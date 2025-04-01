<?php

namespace App\Http\Controllers;

use App\Models\Charge;
use App\Models\Client;
use App\Models\Compte;
use App\Models\facture;
use App\Models\Produit;
use App\Models\Transaction;
use App\Models\Installation;
use App\Models\Proformat;
use App\Models\Vente;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Sum;
use Exception;

class PanierController extends Controller
{

    /**
     * afficher les produit
     */
    public function afficheProduit(Request $request){
        $query = $request->input('q');
        
        // Si une recherche est entrée, filtrer les produits
        if ($query) {
            $produits = Produit::where('name', 'LIKE', "%{$query}%")
                                ->get();
        } else {
            // Sinon, récupérer tous les produits
            $produits = Produit::all();
        }
        
        $comptes = Compte::all();
        $quantite=\Cart::getContent()->count();

        return view('panier.index', compact('produits', 'quantite', 'comptes'));
    }

    //afficher les detail d'un article 
    public function detailProduit(Request $request, $id){

        $produits = Produit::Where('id', $id)->first();

        //verifier que le produit est disponible
        $stock = $produits->stock <= 0 ? 'indisponible' : 'disponible';

        return view('panier.showArticle', [
            "produits" => $produits,
            "stock" => $stock
        ]);
    }




    public function validerVente(Request $request){


            //j'enregistre le client lies a la vente
            if(!$request->client_id){
                $clients = new Client();
                $clients->nom = $request->input('nom');
                $clients->numero = $request->input('numero');
                $clients->save();
            }else{
                $clients = Client::find($request->client_id);
            }

            $comptes = Compte::find( $request->modePaiement);

            if(!$comptes){
                return redirect()->back()->with('error', "vous devez
                choisir le compte pour l'enregistrrement de la vente");
            }
            
            $dateHeure = now();

            $moi = now()->month;
            $annee = $dateHeure->format('y');
            $jour = $dateHeure->format('d');

            //enregistrement transaction
            $transactions = new Transaction();
            
            $transactions->date = $dateHeure->format('Y-m-d');
            $transactions->moi = $moi;
            $transactions->heure = $dateHeure->format('H:i:s');
            // if(!$request->client_id){
            //     $transactions->client_id = $clients->id;
            // }else{
            //     $transactions->client_id = $request->client_id;
            // }
            $transactions->type = 'Vente';
            $transactions->compte_id = $comptes->id;
            $transactions->impot = $request->impot;
            $transactions->montantVerse = $request->input('montantVerse');
            $transactions->user_id = Auth::user()->id;


            //recuperer le panier
            $panier = Session::get('cart', []);
            
            $article= [];
            $prixAchat = 0;

            //quantite total
            $qteTotalProduit = 0;
            
            //montant total du panier sans la reduction
            $montantTotal = 0;
            foreach($panier as $row) {
                $sommePrixAchat = $row['prix_achat'] * $row['quantity'];
                $sommePrixCatalogue = $row['price'] * $row['quantity'];

                $qteTotalProduit = $qteTotalProduit + 1;

                $montantTotal = $montantTotal + $sommePrixCatalogue;
                $prixAchat = $prixAchat + $sommePrixAchat;

            }
            $transactions->prixAchat = $prixAchat;
            

            
            //creation d'une vente
            $ventes = new Vente();
            $ventes->dateEncour = now()->format('m-Y');
            if(!$request->client_id){
                $ventes->client_id = $clients->id;
            }else{
                $ventes->client_id = $request->client_id;
            }
            $ventes->reduction = $request->input('reduction');
            $ventes->agentOperant = $request->input('agentOperant');
            $ventes->commission = $request->input('commission');
            $ventes->montantTotal = $montantTotal;
            $ventes->NetAPayer = $montantTotal - $ventes->reduction;
            $ventes->montantVerse = $request->input('montantVerse');
            $ventes->compte_id = $comptes->id;
            $ventes->impot = $request->input('impot');
            $ventes->qteTotal = $qteTotalProduit;
            $ventes->date = date('d-m-Y');
            $ventes->user_id = Auth::user()->id;
            if($ventes->NetAPayer > $transactions->montantVerse){
                $ventes->statut = "non termine";
                $ventes->dateLimitePaiement = '';
            }
            else{
                $ventes->statut = "termine";
            }
            
            //compter le nombre de vente pour incrementer le numero de la facture
            $numero =Vente::where('date', $ventes->date )->get()->count() + 1;
            $name = Auth::user()->name;
            $numeroFacture = substr($name, 0, 3).'_'.$annee.'_'.$moi.'_'.$jour.'_'.$numero;
            
            //dd($panier);
            $totalPrixAchat = 0;
            //stocker le total des prix d'achat des produits de la facture
            foreach($panier as $produit){
                $articles = Produit::find($produit['id']);
                $prixAchat = $articles->prix_achat;
                $totalPrixAchat = $totalPrixAchat + $prixAchat;
            }
            $ventes->totalAchat = $totalPrixAchat;

            

            $ventes->save();
            if($montantTotal > 50000){
                $charges = new Charge();
                $charges->titre = "commission pour l'intallation de ". $ventes->nomClient. " a ". $ventes->agentOperant; 
                $charges->montant = $ventes->commission;
                $charges->date = $dateHeure->format('Y/m/d');
                $charges->save();
            }

            //je fais une mise a jour du montant dans les comptes
            $comptes->montant = $comptes->montant + $transactions->montantVerse - $ventes->commission;

            $comptes->save();
            $transactions->save();

            //je relie chaque produit du panier a la vente 
            foreach($panier as $produit){
                $ventes->produits()->attach($produit['id'], [
                    'quantity' => $produit['quantity'],
                    'price' => $produit['price']

                ]);
            }

            //je relis chaque produit a la transaction
            foreach ($panier as $item) {
                $transactions->produits()->attach($item['id'], [
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }
            
            //creer une facture pour enregistrer dans le systeme
            $factures = new facture();
            $factures->numeroFacture = $numeroFacture;
            $factures->vente_id = $ventes->id;
            $factures->save();
                    
            // mettre a jour le stock
            foreach($panier as $item){
                $articles = Produit::find($item['id']);
                $articles->stock = $articles->stock - $item['quantity'];
                $articles->save();
            }
            $reduction = $ventes->reduction;
            //net a payer
            $netAPayer = $ventes->montantTotal -  $reduction;

            // chrger les donnee sur la facture pour avoyer sur une vue qui sera converti en pdf
            $pdf = Pdf::loadView('panier.factures',
                [
                    'reduction' => $reduction,
                    'ventes' =>$ventes,
                    'clients' =>$clients,
                    'numeroFacture'=>$numeroFacture,
                    'netAPayer' => $netAPayer,
                    'panier' => $panier
                ]
            );
            
            Session::forget('cart');
   
            return $pdf->stream($numeroFacture.'-'.$clients->numero.'.pdf');
     

    }

    
    public function validerInstallation(Request $request){
        DB::beginTransaction();

        try{

            //j'enregistre le client lies a la vente
            if(!$request->client_id){
                $clients = new Client();
                $clients->nom = $request->input('nom');
                $clients->numero = $request->input('numero');
            }else{
                $clients = Client::find($request->client_id);
            }

            //recuperer le mode de paiement
            $comptes = Compte::find( $request->modePaiement);

            if(!$comptes){
                return redirect()->back()->with('error', "vous devez
                choisir le compte pour l'enregistrrement de la vente");
            }

            $dateHeure = now();

            $moi = now()->month;
            $annee = $dateHeure->format('y');
            $jour = $dateHeure->format('d');
        
            //creer un objet transaction
            $transactions = new Transaction();
            

            $transactions->date = $dateHeure->format('Y/m/d');
            $transactions->moi = $moi;
            $transactions->heure = $dateHeure->format('H:i:s');

            $transactions->type = 'installation';
            $transactions->montantVerse = $request->input('montantVerse');


            $transactions->compte_id = $comptes->id;
            $transactions->impot = $request->impot;
            $transactions->user_id = Auth::user()->id;
            //recuperer les produits du panier
            $panier = Session::get('cart', []);

            $prixAchat = 0;

            //quantite total des produits
            $qteTotalProduit = 0;

            //montant total du panier sans la reduction
            $montantTotal = 0;
            foreach($panier as $row) {
                $sommePrixAchat = $row['prix_achat'] * $row['quantity'];
                $sommePrixCatalogue = $row['price'] * $row['quantity'];

                $qteTotalProduit = $qteTotalProduit + 1;

                $montantTotal = $montantTotal + $sommePrixCatalogue;
                $prixAchat = $prixAchat + $sommePrixAchat;
            }

            $transactions->prixAchat = $prixAchat; 

            //enregistrer l'installation
            $installations = new Installation();
            if(!$request->client_id){
                $installations->client_id = $clients->id;
            }else{
                $installations->client_id = $request->client_id;
            }
            $installations->montantProduit = $montantTotal;
            $installations->reduction = $request->input('reduction');
            $installations->montantVerse = $request->input('montantVerse');
            $installations->agentOperant = $request->input('agentOperant');
            $installations->commission = $request->input('commission');
            $installations->mainOeuvre = $request->input('mainOeuvre');
            $installations->compte_id = $comptes->id;
            $installations->impot = $request->input('impot');
            $installations->qteTotal = $qteTotalProduit;
            $installations->user_id = Auth::user()->id;
            $installations->NetAPayer = ($installations->montantProduit + $installations->mainOeuvre) - $installations->reduction ;

            
            if($installations->NetAPayer > $installations->montantVerse){
                $installations->statut = "non termine";
                $installations->dateLimitePaiement = '';
            }
            else{
                $installations->statut = "termine";
            }


            //compter le nombre de vente pour incrementer le numero de la facture
            $numero =Installation::where('created_at', $installations->created_at )->get()->count() + 1;
            $name = Auth::user()->name;
            $numeroFacture = substr($name, 0, 3).'_'.$annee.'_'.$moi.'_'.$jour.'_'.$numero;
            
            $totalPrixAchat = 0;
            //mettre a jour le stock
            foreach($panier as $produit){
                $articles = Produit::find($produit['id']);
                $prixAchat = $articles->prix_achat;
                $totalPrixAchat = $totalPrixAchat + $prixAchat;
            }
            $installations->totalAchat = $totalPrixAchat;


            $installations->save();
            //comptabiliser la commission comme une charge
            $charges = new Charge();
            $charges->titre = "commission pour l'intallation de ". $installations->nomClient. " a ". $installations->agentOperant; 
            $charges->montant = $installations->commission;
            $charges->date = $dateHeure->format('Y/m/d');

            $charges->save();
            $comptes->save();

            //je fais une mise a jour du montant dans les comptes
            $comptes->montant = $comptes->montant + $transactions->montantVerse;

            $transactions->save();
            $clients->save();
            //je relie chaque produit du pqnier a l'installation
            foreach($panier as $produit){
                $installations->produits()->attach($produit['id'], [
                    'quantity' => $produit['quantity'],
                    'price' => $produit['price'],
                    'installation_id'=>$installations->id

                ]);
            }
            

            // Associer chaque produit du panier à la transaction
            foreach ($panier as $item) {
                $transactions->produits()->attach($item['id'], [
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }
            
            // //creer une facture pour enregistrer dans le systeme
            $factures = new facture();
            $factures->numeroFacture = $numeroFacture;
            $factures->installation_id = $installations->id;
            $factures->save();

            // mettre a jour le stock
            foreach($panier as $item){
                $articles = Produit::find($item['id']);
                $articles->stock = $articles->stock - $item['quantity'];
                $articles->save();
            }
            $reduction = $installations->reduction;
            //net a payer
            $netAPayer = $installations->NetAPayer;

            // chrger les donnee sur la facture pour avoyer sur une vue qui sera converti en pdf
            $pdf = Pdf::loadView('factures.afficherFactureInstallations',[
                'reduction' => $reduction,
                'installations' =>$installations,
                'clients' =>$clients,
                'numeroFacture'=>$numeroFacture,
                'netAPayer' => $netAPayer,
                'factures' =>$factures,
                'panier' => $panier
            ]);
                
            Session::forget('cart');
            Db::commit();   
            return $pdf->stream($numeroFacture.'-'.$clients->numero.'.pdf');
        }catch(Exception $e){
            DB::rollBack(); // En cas d'erreur, on annule tout
    
            return redirect()->back()->with('error', 'Une erreur s\'est produite : ' . $e->getMessage());
        }
    }

    public function validerProformat(Request $request){
        DB::beginTransaction();

        try{

            //j'enregistre le client lies a la vente
            if(!$request->client_id){
                $clients = new Client();
                $clients->nom = $request->input('nom');
                $clients->numero = $request->input('numero');
            }else{
                $clients = Client::find($request->client_id);
            }
            
            $clients->save();

            $dateHeure = now();

            $moi = now()->month;
            $annee = $dateHeure->format('y');
            $jour = $dateHeure->format('d');
        
            //creer un objet transaction
            $transactions = new Transaction();
            

            $transactions->date = $dateHeure->format('Y/m/d');
            $transactions->moi = $moi;
            $transactions->heure = $dateHeure->format('H:i:s');

            $transactions->type = 'proformat';

            $transactions->impot = $request->impot;
            $transactions->user_id = Auth::user()->id;
            //recuperer les produits du panier
            $panier = Session::get('cart', []);

            $prixAchat = 0;

            //quantite total des produits
            $qteTotalProduit = 0;

            //montant total du panier sans la reduction
            $montantTotal = 0;
            foreach($panier as $row) {
                $sommePrixAchat = $row['prix_achat'] * $row['quantity'];
                $sommePrixCatalogue = $row['price'] * $row['quantity'];

                $qteTotalProduit = $qteTotalProduit + 1;

                $montantTotal = $montantTotal + $sommePrixCatalogue;
                $prixAchat = $prixAchat + $sommePrixAchat;
            }

            $transactions->prixAchat = $prixAchat; 

            //enregistrer le proformat
            $proformats = new Proformat();
            if(!$request->client_id){
                $proformats->client_id = $clients->id;
            }else{
                $proformats->client_id = $request->client_id;
            }
            $proformats->montantTotal = $montantTotal;
            $proformats->reduction = $request->input('reduction');
            $proformats->agentOperant = $request->input('agentOperant');
            $proformats->mainOeuvre = $request->input('mainOeuvre');
            $proformats->impot = $request->input('impot');
            $proformats->qteTotal = $qteTotalProduit;
            $proformats->user_id = Auth::user()->id;
            $proformats->NetAPayer = $proformats->montantTotal + $proformats->mainOeuvre - $proformats->reduction ;

            //compter le nombre de vente pour incrementer le numero de la facture
            $numero = Proformat::whereDate('created_at', Carbon::today())->count() + 1;
            $name = Auth::user()->name;
            $numeroFacture = substr($name, 0, 3).'_'.$annee.'_'.$moi.'_'.$jour.'_'.$numero;
            
            $totalPrixAchat = 0;
            
            //stocker le total des prix d'achat des produits de la facture
            foreach($panier as $produit){
                $articles = Produit::find($produit['id']);
                $prixAchat = $articles->prix_achat;
                $totalPrixAchat = $totalPrixAchat + $prixAchat;
            }
            $proformats->totalAchat = $totalPrixAchat;

            $proformats->save();

            $transactions->save();
            //je relie chaque produit du pqnier a la vente 
            foreach($panier as $produit){
                $proformats->produits()->attach($produit['id'], [
                    'quantity' => $produit['quantity'],
                    'price' => $produit['price'],
                    'proformat_id'=>$proformats->id

                ]);
            }
            

            // Associer chaque produit du panier à la transaction
            foreach ($panier as $item) {
                $transactions->produits()->attach($item['id'], [
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }
            
            // //creer une facture pour enregistrer dans le systeme
            $factures = new facture();
            $factures->numeroFacture = $numeroFacture;
            $factures->proformat_id = $proformats->id;
            $factures->save();


            $reduction = $proformats->reduction;
            //net a payer
            $netAPayer = $proformats->NetAPayer;

            // chrger les donnee sur la facture pour avoyer sur une vue qui sera converti en pdf
            $pdf = Pdf::loadView('factures.afficherProformats',[
                'reduction' => $reduction,
                'proformat_id' =>$proformats,
                'clients' =>$clients,
                'numeroFacture'=>$numeroFacture,
                'netAPayer' => $netAPayer,
                'factures' =>$factures,
                'panier' => $panier,
                'proformats' => $proformats
            ]);
            
            Session::forget('cart');
            Db::commit();   
            return $pdf->stream($numeroFacture.'-'.$clients->numero.'.pdf');
        }catch(Exception $e){
            DB::rollBack(); // En cas d'erreur, on annule tout
    
            return redirect()->back()->with('error', 'Une erreur s\'est produite : ' . $e->getMessage());
        }
    }

    //afficher le catalogue des produit pour le proformat
    public function proformat(){
        return view('panier.catalogueProformat');
    }

    public function afficheFacture(){
        return view('panier.factures');
    }
}
