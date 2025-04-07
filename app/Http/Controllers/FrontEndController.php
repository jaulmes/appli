<?php

namespace App\Http\Controllers;

use App\Models\Categori;
use App\Models\Produit;
use App\Models\Realisation;
use App\Models\Service;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    public function index(){
        $produits = Produit::all();
        return view('frontend.index', compact('produits'));
    }

    public function admin(){
        return view('frontend.admin');
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
        $cart = session()->get('cart', []);
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

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Produit ajouté au panier !');
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
