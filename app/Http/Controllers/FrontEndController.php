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

    public function detailRealisation($id){
        $realisation = Realisation::find($id);
        return view('frontend.page.realisationDetail', compact('realisation'));
    }

    public function detailService($id){
        $service = Service::find($id);
        return view('frontend.page.serviceDetail', compact('service'));
    }
}
