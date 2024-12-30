<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Models\Categori;
use App\Models\Compte;
use App\Models\detailAchat;
use App\Models\Produit;
use App\Models\Transaction;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $quantite=\Cart::getContent()->count();
        
        return view('achats.cart', [
            'categoris'=>$categoris,
            'quantite' => $quantite,
            'produits' =>$produits,
            'comptes' => $comptes,
        ]);
    }


    public function achatStoreCart(Request $request){
         //recuperer le produit ajoute dans le panier 
         $produits = Produit::find($request->id);


         //ajouter le produit au panier
          $panier = \Cart::add($request->id, $request->name, $request->prix_achat, 1,array())
                     ->associate($produits);

            return redirect()->back()->with('message', 'produit ajoute au panier');

    }
    
    public function validerAchat(Request $request){
        
        $request->validate([
            'modePaiement' => ['required', 'max:255'],
        ]);
        
        $montantTotal = \Cart::getTotal();

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
        $produits = \Cart::getContent();
        
        
        $article= [];
        $prixAchat = 0;
        foreach($produits as $row) {
    	
    	    $sommePrixAchat = $row->attributes['prix_achat'];;
    	    
    	    $prixAchat = $prixAchat + $sommePrixAchat;
    	    
    	    $article[] =  $row->associatedModel->name;

        }
        $transactions->prixAchat = $prixAchat;
        $transactions->produit = json_encode($article);

        $achats = new Achat();
        $achats->total = $montantTotal;
        $achats->montantVerse = $request->input('montantVerse');
        $achats->compte_id = $comptes->id;
        $achats->impot = $request->input('impot');
        $achats->qte = \Cart::getContent()->count();
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
        //dd($transactions);
        
        $comptes->save();
        $achats->save();

        //mettre a jour le stock
        foreach(\Cart::getContent() as $item){
            $articles = Produit::find($item->id);
            $produit = \Cart::get($articles->id);
            $articles->stock = $articles->stock + $produit->quantity;
            $articles->save();
        }

        \Cart::clear();
        return redirect()->back()->with('message', 'achat enregistré avec succes');
    }


}
