<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    public function index(){
        $fournisseurs = Fournisseur::all();
        return view('produits.afficherFournisseurs', compact('fournisseurs'));
    }

    public function create(){
        return view('produits.ajouterFournisseurs');
    }

    public function store(Request $request){
        $fournisseurs = new Fournisseur();

        $fournisseurs->nom = $request->nom;
        $fournisseurs->prenom = $request->prenom;
        $fournisseurs->telephone = $request->telephone;
        $fournisseurs->localisation = $request->localisation;

        $fournisseurs->save();

        $fournisseurs = Fournisseur::all();

        return view('produits.afficherFournisseurs', compact('fournisseurs'))
                ->with('message', 'fournisseur ajoute avec succes');
    }
}
