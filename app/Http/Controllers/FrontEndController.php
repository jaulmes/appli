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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

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
        $produit_promo = Produit::where('status_promo', 1)->get();
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
            $commande->produits()->attach($item['id'], [
                'quantity' => $item['quantity'],
                'price' => $item['status_promo'] == 0 ? $item['price'] : $item['prix_promo']
            ]);
        }

        $users = User::all();
        Notification::send($users, new NouvelleCommandeNotification("Nouvelle commande"));

    }


    public function detailRealisation($id){
        $realisation = Realisation::find($id);
        return view('frontend.page.realisationDetail', compact('realisation'));
    }

    public function detailService($id){
        $service = Service::find($id);
        return view('frontend.page.serviceDetail', compact('service'));
    }
}
