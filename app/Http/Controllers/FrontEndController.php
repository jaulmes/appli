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
        $produit_promo = Produit::where('status_promo', 1)->get();
        $produit_non_promo = Produit::where('status_promo', 0)->get();
        return view('frontend.allPromoProduit', compact('produit_promo', 'produit_non_promo'));
    }
}
