<?php

namespace App\Http\Controllers;

use App\Models\commande;
use App\Models\Compte;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommandeController extends Controller
{
    public function index()
    {
        //afficher les le nombre de commande non lue
        $nombreCommandesNonLue = DB::table('commandes')->where('status', 0)->count();

        //afficher les commandes non lue
        $commandesNonLue = DB::table('commandes')->where('status', 0)->get();

        return view('commandes.index', 
        [
            'nombreCommandesNonLue' => $nombreCommandesNonLue,
            'commandesNonLue' => $commandesNonLue,
        ]);
    }

    public function commandeDetail($id){
        $commande = commande::find($id);
        $commande->status = 1;
        $commande->save();

        return view('commandes.detail', [
            'commande' => $commande,
        ]);
    }

}
