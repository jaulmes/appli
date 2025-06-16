<?php

namespace App\Http\Controllers;

use App\Models\BonCommande;
use Illuminate\Http\Request;

class BonCommandeController extends Controller
{
    public function index()
    {
        $bonCommandes = BonCommande::all();
        return view('bonCommandes.index', compact('bonCommandes'));
    }

    public function create(){
        return view('bonCommandes.create');
    }
}
