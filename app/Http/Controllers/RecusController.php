<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Compte;
use App\Models\Recu;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecusController extends Controller
{
    public function afficherPdf($id){
        $recus = Recu::with('installations.clients')->find($id);
        
        if($recus->installation_id)
        {
            return $pdf = Pdf::loadView('recus.installation_pdf',
                                        [
                                            'recus' => $recus
                                        ])
                                        ->setPaper([0, 0, 220, 450], 'landscape')
                                        ->stream($recus->numero_recu.'.pdf');
        }elseif($recus->vente_id){
            return $pdf = Pdf::loadView('recus.vente_pdf',
            [
                'recus' => $recus
            ])
            ->setPaper([0, 0, 220, 450], 'landscape')
            ->stream($recus->numero_recu.'.pdf');
        }else{
            return $pdf = Pdf::loadView('recus.simple_pdf',
            [
                'recus' => $recus
            ])
            ->setPaper([0, 0, 220, 450], 'landscape')
            ->stream($recus->numero_recu.'.pdf');
        }
        

    }

    public function afficherVentes($id){
        $recus = Recu::find($id);
        
        return $pdf = Pdf::loadView('recus.installation_pdf',
                    [
                        'recus' => $recus
                    ])
                    ->setPaper([0, 0, 220, 450], 'landscape')
                    ->stream('.pdf');
    }

    public function index(){
        return view('recus.index');
    }

    public function create(){
        $clients = Client::all();
        $comptes = Compte::all();
        return view('recus.create', 
                [
                    'clients' => $clients,
                    'comptes' => $comptes
                ]
            );
    }

    public function store(Request $request){

        $recus = new Recu();
        $transactions = new Transaction();
        $comptes = Compte::find($request->compte_id);

        $recus->user_id = Auth::user()->id;
        $recus->compte_id = $request->compte_id;
        if(!$request->client_id){
            $clients = new Client();
            $clients->nom = $request->nom_client;
            $clients->adresse = $request->adresse_client;
            $clients->numero = $request->numero_client;
            $clients->email = $request->email_client;
            $clients->save();
            $recus->client_id = $clients->id;
        }else{
            $recus->client_id = $request->client_id;
        }
        

        $montantVerse = $request->montant;
        

        $recus->montant_recu = $request->montant;
        $recus->remarque = $request->remarque;
        $recus->dateLimitePaiement = $request->dateLimiteVersement;
        $recus->reste = $request->reste;

        $dateHeure = now();
        $moi = now()->month;

        //compter le nombre de vente pour incrementer le numero de la facture
        $numero = Recu::count() + 1;

        //$numero =Vente::where('date', $ventes->date )->get()->count() + 1;
        $name = Auth::user()->name;
        $numeroFacture = substr($name, 0, 3).'_'.$dateHeure->format('y').'_'.$moi.'_'.$dateHeure->format('d').'_'.$numero;
        $recus->numero_recu = $numeroFacture;

        $recus->save();
        
        $comptes->montant = $comptes->montant + $recus->montant_recu;
        $comptes->save();
        $transactions->montantVerse = $recus->montant_recu;
        $transactions->recu_id = $recus->id;
        $transactions->type = "recu";
        $transactions->save();

        // charger les donnee sur la facture pour avoyer sur une vue qui sera converti en pdf
        return $pdf = Pdf::loadView('recus.simple_pdf',
                    [
                        'recus' => $recus
                    ])
                    ->setPaper([0, 0, 220, 450], 'landscape')
                    ->stream($numeroFacture.'.pdf');
    }
}
