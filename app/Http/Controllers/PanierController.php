<?php

namespace App\Http\Controllers;

use App\Models\Charge;
use App\Models\Client;
use App\Models\Compte;
use App\Models\facture;
use App\Models\Produit;
use App\Models\Transaction;
use App\Models\Installation;
use App\Models\Vente;
use Barryvdh\DomPDF\Facade\Pdf;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Sum;

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

    //rechercher un produit
    public function search(Request $request){
        //je verifie que c'est une requete ajax
        if($request->ajax()){
            //j'initialise l'element quni sera retourne(html ave donne)
            $output = '';
            $query = $request->search;

            //recuperation du produit orrespondant a la recherche
            $produits = Produit::where('name', 'like', "%$query%")
                                ->orWhere('desription', 'like', "%$query%")
                                ->get();
            if($produits){
                foreach ($produits as $produit) {
                    $output .= "<div class='col mb-3' style='margin-right: -4em;'>
                                    <div class='card h-100' style='width: 12em;'>
                                        <strong class='badge badge-danger'>" . $produit->getAlert() . "</strong>";
        
                    if ($produit->getStock() === 'disponible') {
                        $output .= "<strong class='badge badge-info'>" . $produit->getStock() . "</strong>";
                    } elseif ($produit->getStock() === 'indisponible') {
                        $output .= "<strong class='badge badge-danger'>" . $produit->getStock() . "</strong>";
                    }
        
                    $output .= "<img src='" . asset('storage/images/produits/' . $produit->image_produit) . "' class='img-fluid' style='height: 5em; width: 100%;'>
                                        <div class='member-info' style='font-size: 12px;'>
                                            <h7><u>Nom</u>: " . $produit->name . "</h7>
                                            <p class='card-text'><u>Desc</u>: " . $produit->getDescription() . "</p>
                                            <p class='card-text'><u>Prix</u>: <strong class='text-success'>" . $produit->getPrice() . "</strong></p>
                                            <div class='row' style='margin-left: 0.2em; padding-bottom: 0.01em; margin-top: 0.5em;'>
                                                <a href='" . route('produit.detail', $produit->id) . "'>
                                                    <button class='btn btn-warning px-1'><i class='bi bi-eye'></i></button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>";
                }
                return response()->json($output);
            }

        }

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

    public function ajouterAuPanier(Request $request){

        //recuperer le produit ajoute dans le panier 
        $produits = Produit::find($request->id);


        // $cart = \Cart::getContent();

        // $itemNames=[];
        // // Parcours le panier pour trouver le nombre de fois que le produit est ajouté au panier
        // foreach ($cart as $item) {
        //     $itemNames[]=$item->name;
            
            
        // }
        // //dd($itemNames);
        // $occurences=array_count_values($itemNames);
        
        // //$quantite=2;
        // foreach($occurences as $itemNames=>$count){

        //     if($count>1){
        //         return redirect()->route('panier.index')->with('erreur', 'produit deja ete ajoute au panier');
        //     }
        //     else{
                
        //     }
        // }


        //ajouter le produit au panier
         $panier = \Cart::add($request->id, $request->name, $request->price, 1,array())
                    ->associate($produits);

        return redirect()->route('panier.index')->with('message', 'produit ajoute au panier');
    }

    public function retirerProduit($id, Request $request){
        
        \Cart::remove($request->id);

        return redirect()->back();
    }

    //afficher le panier de l'utilisateur
    public function index(){
        $panier = \Cart::getContent();
        return view('panier.monPanier', compact('panier'));
    }



    public function update( Request $request, $id){
        

        $data = $request->json()->all();
 
        if($data['quantity'] > $data['stock']){
            Session::flash('erreur', 'la quantite de ce produit est insufisante');
            return response()->json(['erreur'=> 'produit insufisant']);
        }
        \Cart::update($id, [
            'quantity' => $data['quantity']
        ]);
        Session::flash('succes', 'la quantite a bien ete mis a jour');
        return response()->json(['Success'=> 'panier mis a jour avec succes']);

    }

    public function delete($id){
        \Cart::remove($id);
        return redirect()->back();
    }

    public function validerVente(Request $request){
        //j'enregistre le client lies a la vente
        $clients = new Client();
        $clients->nom = $request->input('nom');
        $clients->numero = $request->input('numero');

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
        $transactions->nomClient =$clients->nom;
        $transactions->numeroClient = $clients->numero;
        $transactions->type = 'Vente';
        $transactions->compte_id = $comptes->id;
        $transactions->impot = $request->impot;
        $transactions->montantVerse = $request->input('montantVerse');
        $transactions->user_id = Auth::user()->id;

        //recuperer le panier
        $panier = \Cart::getContent();
        
        $article= [];
        $prixAchat = 0;
        //dd($panier);
        foreach($panier as $row) {
    	
    	    $sommePrixAchat = $row->attributes['prix_achat'];
    	    
    	    $prixAchat = $prixAchat + $sommePrixAchat;
    	    
    	    $article[] =  $row->associatedModel->name;

        }
        $transactions->prixAchat = $prixAchat;
        $transactions->produit = json_encode($article);
        
        //montant total du panier sans la reduction
        $montantTotal = \Cart::getTotal();

        //creation d'une vente
        $ventes = new Vente();
        $ventes->dateEncour = now()->format('m-Y');
        $ventes->nomClient = $request->input('nom');
        $ventes->numeroClient = $request->input('numero');
        $ventes->montantVerse = $request->input('montantVerse');
        $ventes->reduction = $request->input('reduction');
        $ventes->agentOperant = $request->input('agentOperant');
        $ventes->commission = $request->input('commission');
        $ventes->montantTotal = $montantTotal;
        $ventes->NetAPayer = $montantTotal - $ventes->reduction;
        $ventes->compte_id = $comptes->id;
        $ventes->impot = $request->input('impot');
        $ventes->qteTotal = \Cart::getContent()->count();
        $ventes->date = date('d-m-Y');
        $ventes->user_id = Auth::user()->id;
        if($ventes->NetAPayer > $transactions->montantVerse){
            $ventes->statut = "non termine";
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
        //mettre a jour le stock
        foreach($panier as $produit){
            $articles = Produit::find($produit->id);
            $prixAchat = $articles->prix_achat;
            $totalPrixAchat = $totalPrixAchat + $prixAchat;
        }
        $ventes->totalAchat = $totalPrixAchat;

        if(\Cart::getTotal() > 50000){
            $charges = new Charge();
            $charges->titre = "commission pour l'intallation de ". $ventes->nomClient. " a ". $ventes->agentOperant; 
            $charges->montant = $ventes->commission;
            $charges->date = $dateHeure->format('Y/m/d');
            $charges->save();
        }

        //je fais une mise a jour du montant dans les comptes
        $comptes->montant = $comptes->montant + $transactions->montantVerse - $ventes->commission;

        $comptes->save();
        $ventes->save();
        $transactions->save();
        $clients->save();

        //je relie chaque produit du panier a la vente 
        foreach($panier as $produit){
            $ventes->produits()->attach($produit->id, [
                'quantity' => $produit->quantity,
                'price' => $produit->price

            ]);
        }
        
        //creer une facture pour enregistrer dans le systeme
        $factures = new facture();
        $factures->numeroFacture = $numeroFacture;
        $factures->vente_id = $ventes->id;
        $factures->save();
                
        // mettre a jour le stock
        foreach(\Cart::getContent() as $item){
            $articles = Produit::find($item->id);
            $produit = \Cart::get($articles->id);
            $articles->stock = $articles->stock - $produit->quantity;
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
            ]
        );
        
         \Cart::clear();       
        return $pdf->stream($numeroFacture);
    }
    
    public function validerInstallation(Request $request){
        
        //creer un objet transaction
        $transactions = new Transaction();
        
        //j'enregistre le client lies a la vente
        $clients = new Client();
        $clients->nom = $request->input('nom');
        $clients->numero = $request->input('numero');

        
        $dateHeure = now();

        $moi = now()->month;
        $annee = $dateHeure->format('y');
        $jour = $dateHeure->format('d');

        //recuperer les produits du panier
        $panier = \Cart::getContent();

        $article= [];
        $prixAchat = 0;
        foreach($panier as $row) {
    	
    	    $sommePrixAchat = $row->associatedModel->prix_achat;
    	    
    	    $prixAchat = $prixAchat + $sommePrixAchat;
    	    
    	    $article[] =  $row->associatedModel->name;

        }

        //enregistrement transaction
        $transactions->prixAchat = $prixAchat;
        $transactions->produit = json_encode($article);     
        $transactions->date = $dateHeure->format('Y/m/d');
        $transactions->moi = $moi;
        $transactions->heure = $dateHeure->format('H:i:s');
        $transactions->nomClient =$clients->nom;
        $transactions->numeroClient = $clients->numero;
        $transactions->type = 'installation';
        $transactions->montantVerse = $request->input('montantVerse');

        //recuperer le mode de paiement
        $comptes = Compte::find( $request->modePaiement);
        
        //je fais une mise a jour du montant dans les comptes
        $comptes->montant = $comptes->montant + $transactions->montantVerse;

        $transactions->compte_id = $comptes->id;
        $transactions->impot = $request->impot;
        $transactions->user_id = Auth::user()->id;

        //recuperer le montant total du panier
        $montantTotal = \Cart::getTotal();

        //enregistrer l'installation
        $installations = new Installation();
        $installations->nomClient = $request->input('nom');
        $installations->numeroClient = $request->input('numero');
        $installations->montantProduit = $montantTotal;
        $installations->reduction = $request->input('reduction');
        $installations->montantVerse = $request->input('montantVerse');
        $installations->agentOperant = $request->input('agentOperant');
        $installations->commission = $request->input('commission');
        $installations->mainOeuvre = $request->input('mainOeuvre');
        $installations->compte_id = $comptes->id;
        $installations->impot = $request->input('impot');
        $installations->qteTotal = \Cart::getContent()->count();
        $installations->user_id = Auth::user()->id;
        $installations->NetAPayer = ($installations->montantProduit + $installations->mainOeuvre) - $installations->reduction ;
       // dd($installations);
        
        if($installations->NetAPayer > $installations->montantVerse){
            $installations->statut = "non termine";
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
            $articles = Produit::find($produit->id);
            $prixAchat = $articles->prix_achat;
            $totalPrixAchat = $totalPrixAchat + $prixAchat;
        }
        $installations->totalAchat = $totalPrixAchat;

        //comptabiliser la commission comme une charge
        $charges = new Charge();
        $charges->titre = "commission pour l'intallation de ". $installations->nomClient. " a ". $installations->agentOperant; 
        $charges->montant = $installations->commission;
        $charges->date = $dateHeure->format('Y/m/d');
         //dd($installations->mainOeuvre);
        $charges->save();
        $comptes->save();
        $installations->save();
        $transactions->save();
        $clients->save();
        
        //je relie chaque produit du pqnier a la vente 
        foreach($panier as $produit){
            $installations->produits()->attach($produit->id, [
                'quantity' => $produit->quantity,
                'price' => $produit->price,
                'installation_id'=>$installations->id

            ]);
        }
        
        // //creer une facture pour enregistrer dans le systeme
        $factures = new facture();
        $factures->numeroFacture = $numeroFacture;
        $factures->installation_id = $installations->id;
        $factures->save();
                
        // mettre a jour le stock
        foreach(\Cart::getContent() as $item){
            $articles = Produit::find($item->id);
            $produit = \Cart::get($articles->id);
            $articles->stock = $articles->stock - $produit->quantity;
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
            'factures' =>$factures
        ]);
        
        //\Cart::clear();       
        return $pdf->stream($numeroFacture);
    }

    public function afficheFacture(){
        return view('panier.factures');
    }
}
