<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Vente;
use Illuminate\Http\Request;
use Auth;
class VentesController extends Controller
{
    //afficher toutes les ventes
    public function index(){
        $ventes = Vente::all();
        return view('ventes.index', compact('ventes'));
    }

    //afficher les ventes pour impots
    public function ventesImpot(){

        $ventes = Vente::where('impot', 'on')->get();
        return view('ventes.impot', compact('ventes'));
    }

    //affiche les ventes terminé
    public function ventesTermine(){
        $userId = Auth::User()->id;
        $ventes = Vente::where('user_id', 'userId')->get();
        return view('ventes.termine', compact('ventes'));
    }

    //affiche les ventes non terminé
    public function ventesNonTermine(){
        $ventes = Vente::where('statut', 'non termine')->get();
        return view('ventes.non-termine', compact('ventes'));
    }

    //modifier les ventes non termine
    public function modifierVente($id){
        $ventes = Vente::where('id', $id);
        return view('ventes.modifier', compact('ventes'));
    }

    //enregistrer les modification
    public function updateVente(Request $request, $id){
        $ventes= Vente::where('id', $id)->first();

        $ancientMontantVerse = $ventes->montantVerse;

        $nouveauMontantVerse = $request->input('montantVerse');

        $ventes->montantVerse = $ancientMontantVerse + $nouveauMontantVerse;
        

        $transactions = new Transaction();
        $dateHeure = now();

        $transactions->date = $dateHeure->format('d/m/y');
        $transactions->heure = $dateHeure->format('H:i:s');
        $transactions->nomClient =$ventes->nomClient;
        $transactions->numeroClient = $ventes->numeroClient;
        $transactions->type = 'reglement de facture de vente';
        $transactions->modePaiement = $request->modePaiement;
        $transactions->montantVerse = $request->input('montantVerse');


        
        if($ventes->montantTotal > $ventes->montantVerse){
            $ventes->statut = "non termine";
            $ventes->save();
            return redirect()->route('ventes.nonTermine');
        }
        else{
            $ventes->statut = "termine";
            $ventes->save();
            return redirect()->route('ventes.termine');
        }

        

    }
}
