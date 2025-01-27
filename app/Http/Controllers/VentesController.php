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
        $ventes = Vente::where('statut', 'non termine')->latest()->get();
        return view('ventes.non-termine', compact('ventes'));
    }
    
    //filtrer les ventes
    public function filtrerVentes(Request $request){
        if($request->ajax()){
            $statut = $request->statut;
            $output = '';
            //je prepare ma requete
            $query = Vente::query();

            //je filtre ma requete on fonction du statut
            if($statut == 'termine'){
                $query->where('statut', 'termine');
            }
            elseif($statut == 'non_termine'){
                $query->where('statut', 'non termine');
            }

            //je recupere les ventes dans la bd
            $ventes = $query->get();

            if($ventes){
                foreach($ventes as $vente) {
                    $output .=
                    '<tr>
                        <td>'.$vente->nomClient.'</td>
                        <td>'.$vente->numeroClient.'</td>
                        <td>'.$vente->user->name.'</td>
                        <td>'.$vente->qteTotal.'</td>
                        <td>'.$vente->NetAPayer.'</td>
                        <td>'.$vente->montantTotal.'</td>
                        <td>'.$vente->montantVerse.'</td>
                        <td>'.$vente->date.'</td>
                        <td>'.$vente->statut.'</td>
                    </tr>
                  ';
                }
            }
            return response()->json($output);
        }
        return view('ventes.index', compact('ventes'));
    }

    //rechercher
    public function rechercherVente(Request $request){
        if($request->ajax()){
            $output = '';

            $ventes = Vente::where('nomClient', 'like', "%$request->search%")->get();

            if($ventes) {

                foreach($ventes as $vente) {

                    $output .=
                    '<tr>
                        <td>'.$vente->nomClient.'</td>
                        <td>'.$vente->numeroClient.'</td>
                        <td>'.$vente->user->name.'</td>
                        <td>'.$vente->agentOperant.'</td>
                        <td>'.$vente->commission.'</td>
                        <td>'.$vente->qteTotal.'</td>
                        <td>'.$vente->NetAPayer.'</td>
                        <td>'.$vente->montantTotal.'</td>
                        <td>'.$vente->montantVerse.'</td>
                        <td>'.$vente->date.'</td>
                        <td>'.$vente->statut.'</td>
                    </tr>
                    
                  ';

                }

                return response()->json($output);

            }
            return view('ventes.index', compact('ventes'));
        }
        
        //return response()->json($ventes);
        return view('ventes.non-termine', compact('ventes'))->render();
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
