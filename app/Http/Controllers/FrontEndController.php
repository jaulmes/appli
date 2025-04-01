<?php

namespace App\Http\Controllers;

use App\Models\Produit;
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
}
