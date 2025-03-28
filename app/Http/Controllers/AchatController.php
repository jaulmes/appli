<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Models\Categori;
use App\Models\Compte;
use App\Models\detailAchat;
use App\Models\Produit;
use App\Models\Transaction;
use Darryldecode\Cart\Cart;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AchatController extends Controller
{
    public function index(){
        $achats = Achat::all();
        $comptes = Compte::all();
        return view('achats.index', compact('achats', 'comptes'));
    }

    //afficher les achat pour impots
    public function achatsImpot(){

        $achats = Achat::where('impot', 'on')->get();
        return view('achats.impot', compact('achats'));
    }

    public function create(){
        $categoris= Categori::all();
        
        return view('achats.ajouter', [
            'categoris'=>$categoris,
        ]);
    }
    public function afficherProduitCategorise( Request $request){
        $id = $request->input('categori_id');

        $produits = Produit::where('categori_id', $id)->get();
        return response()->json($produits);
    }

    public function createAchat(Request $request){
        $produits = Produit::all();
        $categoris= Categori::all();
        $comptes = Compte::all();

        $qteTotalProduit = 0;
            
        //quantite total de produit
        $quantite = 0;
        $panier = Session::get('cart', []);
        foreach($panier as $row) {
            $qteTotalProduit = $qteTotalProduit + 1;

        }
        
        return view('achats.cart', [
            'categoris'=>$categoris,
            'quantite' => $quantite,
            'produits' =>$produits,
            'comptes' => $comptes,
        ]);
    }
    
    public function validerAchat(Request $request){
        $request->validate([
            'modePaiement' => ['required', 'max:255'],
        ]);

        //recuperer le panier
        $panier = Session::get('cart', []);
        
        $prixAchat = 0;

        //quantite total
        $qteTotalProduit = 0;
        
        //montant total du panier sans la reduction

        foreach($panier as $row) {
            $sommePrixAchat = $row['prix_achat'] * $row['quantity'];

            $qteTotalProduit = $qteTotalProduit + 1;

            $prixAchat = $prixAchat + $sommePrixAchat;
        }

        $comptes = Compte::find( $request->modePaiement);
        
        $dateHeure = now();

        //enregistrement transaction
        $transactions = new Transaction();
        $transactions->date = $dateHeure->format('d/m/y');
        $transactions->heure = $dateHeure->format('H:i:s');
        $transactions->type = 'Achat';
        $transactions->impot = $request->impot;
        $transactions->compte_id = $comptes->id;
        $transactions->user_id = Auth::user()->id;
        
        
        // $article= [];
        $prixAchat = 0;
        foreach($panier as $row) {
            $sommePrixAchat = $row['prix_achat'] * $row['quantity'];
            $prixAchat = $prixAchat + $sommePrixAchat;
            

            }
        $transactions->prixAchat = $prixAchat;
        // $transactions->produit = json_encode($article);

        $achats = new Achat();
        $achats->total = $prixAchat;
        $achats->montantVerse = $request->input('montantVerse');
        $achats->compte_id = $comptes->id;
        $achats->impot = $request->input('impot');
        $achats->qte = $qteTotalProduit;
        $achats->date = date('d-m-Y');
        $achats->user_id = Auth::user()->id;
        if($achats->total > $achats->montantVerse){
            $achats->statut = "non termine";
        }
        else{
            $achats->statut = "termine";
        }

        if($comptes->montant < $achats->montantVerse){
            return redirect()->back()->
            with(
                'error', "le montant present dans le compte " . $comptes->nom . " est insufisant! veuillez recharger le compte ou changer de moyen de paiement"
            );
        }

        $comptes->montant = $comptes->montant - $achats->montantVerse;
        
        $transactions->save();
        
        $comptes->save();
        $achats->save();
        //je relie chaque produit du panier a l'achat
        foreach($panier as $produit){
            $achats->produits()->attach($produit['id'], [
                'quantity' => $produit['quantity'],
                'price' => $produit['prix_achat'],
                'achat_id'=>$achats['id']
            ]);
        }

        // Associer chaque produit du panier à la transaction
        foreach ($panier as $item) {
            $transactions->produits()->attach($item['id'], [
                'quantity' => $item['quantity'],
                'price' => $item['prix_achat'],
                'name' => $item['name']
            ]);
        }

        //mettre a jour le stock
        foreach($panier as $item){
            $articles = Produit::find($item['id']);
            $articles->stock = $articles->stock + $produit['quantity'];
            $articles->save();
        }

        return redirect()->back()->with('message', 'achat enregistré avec succes');
    }

}
