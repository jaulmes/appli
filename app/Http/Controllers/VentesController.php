<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Compte;
use App\Models\Installation;
use App\Models\Recu;
use App\Models\Transaction;
use App\Models\Vente;
use Illuminate\Http\Request;
use Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\DB;

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
        $userId = FacadesAuth::User()->id;
        $ventes = Vente::where('user_id', 'userId')->get();
        return view('ventes.termine', compact('ventes'));
    }

    public function formShow($id){
        $ventes = Vente::find($id);
        $clients = Client::all();
        $comptes = Compte::all();
        
        return view('ventes.formAjouterPaiement', [
            'ventes' => $ventes,
            'clients' => $clients,
            'comptes' => $comptes
        ]);
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

    public function ajouterPaiement(Request $request, $id){

        $ventes = Vente::find($id);

        $recus = new Recu();
        $transactions = new Transaction();
        $comptes = Compte::find($request->compte_id);

        $recus->user_id = FacadesAuth::user()->id;
        $recus->vente_id = $ventes->id;
        $recus->compte_id = $request->compte_id;
        if($ventes->client_id){
            $recus->client_id = $ventes->client_id;
        }else{
            $recus->client_id = $request->client_id;
            $ventes->client_id = $request->client_id;
        }

        //verifier que le solde est suffisant
        if($comptes->montant < $request->montant){
            return redirect()->back()->with('message', 'le solde est insufisant. recharger le compte ou changer de moyen de paiement');
        }
        $montantVerse = $request->montant + $ventes->montantVerse;
        
        //verifier que le montant verse n'est pas superrieur au reste a payer
        if($ventes->NetAPayer < $montantVerse){
            return redirect()->back()->with('message', 'le montant versé est superieur au reste a payer');
        }
        $recus->montant_recu = $request->montant;
        $recus->remarque = $request->remarque;

        $dateHeure = now();
        $moi = now()->month;

        //compter le nombre de vente pour incrementer le numero de la facture
        $numero = Recu::count() + 1;

        //$numero =Vente::where('date', $ventes->date )->get()->count() + 1;
        $name = FacadesAuth::user()->name;
        $numeroFacture = substr($name, 0, 3).'_'.$dateHeure->format('y').'_'.$moi.'_'.$dateHeure->format('d').'_'.$numero;
        $recus->numero_recu = $numeroFacture;
        $ventes->montantVerse = $ventes->montantVerse + $request->montant;

        if($ventes->NetAPayer > $ventes->montantVerse ){
            $ventes->statut = "non termine";
            $ventes->dateLimitePaiement = $request->dateLimiteVersement;
        }
        else{
            $ventes->statut = "termine";
        }

        $recus->save();
        
        $comptes->montant = $comptes->montant + $recus->montant_recu;
        $comptes->save();
        $ventes->save();
        //dd($recus->ventes->clients->nom);
        $transactions->recu_id = $recus->id;
        $transactions->type = "recu";
        $transactions->save();

        // charger les donnee sur la facture pour avoyer sur une vue qui sera converti en pdf
        return $pdf = Pdf::loadView('recus.vente_pdf',
                    [
                        'recus' => $recus
                    ])
                    ->setPaper([0, 0, 220, 450], 'landscape')
                    ->stream($numeroFacture);
        
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
