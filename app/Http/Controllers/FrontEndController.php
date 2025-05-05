<?php

namespace App\Http\Controllers;

use App\Models\Categori;
use App\Models\Client;
use App\Models\commande;
use App\Models\Produit;
use App\Models\Realisation;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\NouvelleCommandeNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;

class FrontEndController extends Controller
{
    public function index(){
        $produits = Produit::all();
        return view('frontend.index', compact('produits'));
    }

    public function admin(){
        return view('frontend.admin');
    }

    public function allPromoProduitAdmin(){
        $produit_promo = Produit::where('status_promo', 1)
                                    ->orderByRaw('position_promo IS NULL, position_promo ASC')
                                    ->get();
        return view('frontend.allPromoProduit', compact('produit_promo'));
    }

    public function allPromoProduit(){
        $produits = Produit::where('status_promo', 1)->get();
        return view('frontend.page.nosProduitPromo', compact('produits'));
    }

    public function allCategories(){
        $categories = Categori::all();
        return view('frontend.page.nosCategorie', compact('categories'));
    }

    public function categorieDetail($id){
        $produits = Produit::where('categori_id', $id)->get();
        return view('frontend.page.categorieDetail', compact('produits'));
    }

    public function detailProduit($id){
        $produit = Produit::find($id);
        return view('frontend.page.produitDetail', compact('produit'));
    }

    public function addToCart($id){
        $produit = Produit::find($id);
        $cart = session()->get('frontEndCart', []);
        if(isset($cart[$id])){
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'quantity' => 1,
                'id' => $produit->id,
                'name' => $produit->name,
                'image' => $produit->image_produit,
                'price' => $produit->price,
                'prix_catalogue' => $produit->price,
                'prix_promo' => $produit->prix_promo,
                'status_promo' => $produit->status_promo
            ];
        }

        session()->put('frontEndCart', $cart);
        return redirect()->back()->with('success', 'Produit ajouté au panier !');
    }

    public function passerCommande(){
        $cart = session()->get('frontEndCart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Votre panier est vide !');
        }
        $montantTotal = array_reduce($cart, function($total, $produit) {
            $price = $produit['status_promo'] == 0 ? $produit['price'] : $produit['prix_promo'];
            return $total + ($produit['quantity'] * $price);
        }, 0);
        return view('frontend.page.passerCommande', compact('cart', 'montantTotal'));
    }

    public function validerCommande( Request $request){
        $cart = session()->get('frontEndCart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Votre panier est vide !');
        }
        $clientEnregistre = Client::where('numero', $request->numero)->first();
        if($clientEnregistre){
            $client = $clientEnregistre;
        }else{
            $client = new Client();
            $client->nom = $request->name;
            $client->numero = $request->numero;
            $client->email = $request->email;
            $client->adresse = $request->address;
            $client->save();
        }

        $montantTotal = array_reduce($cart, function($total, $produit) {
            $price = $produit['status_promo'] == 0 ? $produit['price'] : $produit['prix_promo'];
            return $total + ($produit['quantity'] * $price);
        }, 0);

        $commande = new commande();
        $commande->client_id = $client->id;
        $commande->montant_total = $montantTotal;
        $commande->status = 0;
        
        $commande->save();

        //compter le nombre de commande pour incrementer le numero de la facture
        $numero =commande::whereDate('created_at', $commande->created_at )->get()->count() + 1;
        $commande->numero_commande = $client->numero.'_'.$commande->created_at->format('Y').'_'.$commande->created_at->format('m').'_'.$commande->created_at->format('d').'_'.$numero;
        //reengistrer la commande aves le numero de la facture
        $commande->save();

        $transactions = new Transaction();
        $transactions->commande_id = $commande->id;
        $transactions->type = "commande passée sur le site";
        $transactions->save();

        //je relis chaque produit a la transaction
        foreach ($cart as $item) {
            $transactions->produits()->attach($item['id'], [
                'quantity' => $item['quantity'],
                'price' => $item['status_promo'] == 0 ? $item['price'] : $item['prix_promo']
            ]);
        }

        //je relie les produits aux commandes
        foreach ($cart as $item) {
            $produit = Produit::find($item['id']);
            $commande->produits()->attach($item['id'], [
                'quantity' => $item['quantity'],
                'price' => $item['status_promo'] == 0 ? $item['price'] : $item['prix_promo'],
                'status_produit' => $produit->stock >= 0 ? 'en stock' : 'signaler au responsable'
            ]);
        }

        $users = User::all();
        Notification::send($users, new NouvelleCommandeNotification("Nouvelle commande"));
        Session::forget('cart');
        return view('frontend.page.commandeValidee', compact('commande'));
    }

    //afficher la facture de la commande
    public function afficherFactureComande($id){
        $commande = commande::find($id);
        $montantTotal = 0;
        foreach ($commande->produits as $produit) {
            $montantTotal += $produit->pivot->price * $produit->pivot->quantity;
        }
        $pdf = Pdf::loadView('frontend.page.factureCommande',
                [
                    'commandes' =>$commande,
                    'montantTotal' => $montantTotal,
                ]
            );

        return $pdf->stream($commande->numero_facture.'-'.$commande->clients->numero.'.pdf');
    }

    //telecharger la facture de la commande
    public function telechargerFactureComande($id){
        $commande = commande::find($id);
        $montantTotal = 0;
        foreach ($commande->produits as $produit) {
            $montantTotal += $produit->pivot->price * $produit->pivot->quantity;
        }
        $pdf = Pdf::loadView('frontend.page.factureCommande',
                [
                    'commandes' =>$commande,
                    'montantTotal' => $montantTotal,
                ]
            );

        return $pdf->download($commande->numero_facture.'-'.$commande->clients->numero.'.pdf');
    }


    public function detailRealisation($id){
        $realisation = Realisation::find($id);
        return view('frontend.page.realisationDetail', compact('realisation'));
    }

    public function allProduits(){
        $produits = Produit::all();
        return view('frontend.page.allProduit', compact('produits'));
    }

    public function detailService($id){
        $service = Service::find($id);
        return view('frontend.page.serviceDetail', compact('service'));
    }

    public function allServices(){
        $services = Service::all();
        return view('frontend.page.nosServices', compact('services'));
    }
    public function allRealisations(){
        $realisations = Realisation::all();
        return view('frontend.page.allRealisation', compact('realisations'));
    }

    public function simulateur(){
        return view('frontend.page.simulateur');
    }
}
