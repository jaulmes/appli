<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Compte;
use App\Models\Installation;
use App\Models\Recu;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstallationController extends Controller
{
    // public function ajouterPaiement($id){
    //     $installations = Installation::find($id);
    //     return view('installations.ajouterPaiement', compact('installations'));
    // }
    public function ajouterPaiement(Request $request, $id){
        $installations = Installation::find($id);

        $recus = new Recu();
        $transactions = new Transaction();
        $comptes = Compte::find($request->compte_id);

        $recus->user_id = Auth::user()->id;
        $recus->installation_id = $installations->id;
        $recus->compte_id = $request->compte_id;
        if($installations->client_id){
            $recus->client_id = $installations->client_id;
        }else{
            $recus->client_id = $request->client_id;
            $installations->client_id = $request->client_id;
        }

        $montantVerse = $request->montant + $installations->montantVerse;
        
        //verifier que le montant verse n'est pas superrieur au reste a payer
        if($installations->NetAPayer < $montantVerse){
            return redirect()->back()->with('message', 'le montant versé est superieur au reste a payer');
        }
        $recus->montant_recu = $request->montant;
        $recus->remarque = $request->remarque;

        $dateHeure = now();
        $moi = now()->month;

        //compter le nombre de vente pour incrementer le numero de la facture
        $numero = Recu::count() + 1;

        //$numero =Vente::where('date', $installations->date )->get()->count() + 1;
        $name = Auth::user()->name;
        $numeroFacture = substr($name, 0, 3).'_'.$dateHeure->format('y').'_'.$moi.'_'.$dateHeure->format('d').'_'.$numero;
        $recus->numero_recu = $numeroFacture;
        $installations->montantVerse = $installations->montantVerse + $request->montant;

        if($installations->NetAPayer > $installations->montantVerse ){
            $installations->statut = "non termine";
            $installations->dateLimitePaiement = $request->dateLimiteVersement;
        }
        else{
            $installations->statut = "termine";
        }

        $recus->save();
        
        $comptes->montant = $comptes->montant + $recus->montant_recu;
        $comptes->save();
        $installations->save();
        //dd($recus->installations->clients->nom);
        $transactions->recu_id = $recus->id;
        $transactions->type = "recu";
        $transactions->save();

        // charger les donnee sur la facture pour avoyer sur une vue qui sera converti en pdf
        return $pdf = Pdf::loadView('recus.installation_pdf',
                    [
                        'recus' => $recus
                    ])
                    ->setPaper([0, 0, 220, 450], 'landscape')
                    ->stream($numeroFacture);
    }

    public function formShow($id){
        $installations = Installation::find($id);
        $clients = Client::all();
        $comptes = Compte::all();
        
        return view('installations.formAjouterPaiement', [
            'installations' => $installations,
            'clients' => $clients,
            'comptes' => $comptes
        ]);
    }

    public function index(){
        $installations = Installation::orderBy('created_at', 'desc')
                                        ->get();
        return view('installations.index', compact('installations'));
    }
    
}
