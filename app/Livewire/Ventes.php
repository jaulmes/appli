<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Compte;
use App\Models\Recu;
use App\Models\Transaction;
use App\Models\Vente;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Ventes extends Component
{
    public $ventes = [];
    public $query;
    public $client_id;
    public $clients = [];
    public $comptes = [];
    public $compte_id;
    public $remarque;
    public $montant;
    public $type = 'all';
    public $nbreNonTermine;

    public function filter($type){
        if($type == 'all'){
            $this->ventes = Vente::orderBy('id', 'desc')->get();
            $this->type = 'all';
            return;
        }
        if ($type === 'termine') {
            // Ventes terminées : NetAPayer - montantVerse <= 0
            $this->ventes = Vente::whereRaw('NetAPayer - montantVerse <= 0')
                ->orderBy('id', 'desc')
                ->get();
            $this->type = 'termine';
            return;
        }
    
        if ($type === 'non_termine') {
            // Ventes non terminées : NetAPayer - montantVerse > 0
            $this->ventes = Vente::whereRaw('NetAPayer - montantVerse > 0')
                ->orderBy('id', 'desc')
                ->get();

            $this->type = 'non_termine';
            return;
        }
    }

    public function mount(){
        $this->ventes = Vente::orderBy('id', 'desc')->get();
        //nombre de vente non terminée
        $this->nbreNonTermine = Vente::whereRaw('NetAPayer - montantVerse > 0')->count();


        $this->clients = Client::all();
        $this->comptes = Compte::all();
    }

    public function ajouterPaiement( $id){
        $ventes = Vente::find($id);
        //dd($installations->clients->name);
        $recus = new Recu();
        $transactions = new Transaction();
        $comptes = Compte::find($this->compte_id);

        $recus->user_id = Auth::user()->id;
        $recus->vente_id = $ventes->id;
        $recus->compte_id = $this->compte_id;
        if($ventes->client_id){
            $recus->client_id = $ventes->client_id;
        }else{
            $recus->client_id = $this->client_id;
        }
        $recus->montant_recu = $this->montant;
        $recus->remarque = $this->remarque;

        $dateHeure = now();
        $moi = now()->month;

        //compter le nombre de vente pour incrementer le numero de la facture
        $numero = Recu::count() + 1;

        //$numero =Vente::where('date', $ventes->date )->get()->count() + 1;
        $name = Auth::user()->name;
        $numeroFacture = substr($name, 0, 3).'_'.$dateHeure->format('y').'_'.$moi.'_'.$dateHeure->format('d').'_'.$numero;
        $recus->numero_recu = $numeroFacture;
        $ventes->montantVerse = $ventes->montantVerse + $this->montant;
        if($ventes->NetAPayer > $ventes->montantVerse ){
            $ventes->statut = "non termine";
        }
        else{
            $ventes->statut = "termine";
        }
        $recus->save();
        $comptes->montant = $comptes->montant + $recus->montant_recu;
        $comptes->save();
        $ventes->save();
        $transactions->recu_id = $recus->id;
        $transactions->type = "recu";
        $transactions->save();
        dd($transactions, $comptes, $recus, $ventes);
        
        // chrger les donnee sur la facture pour avoyer sur une vue qui sera converti en pdf
        $pdf = Pdf::loadView('recus.installation_pdf',
            [
                'ventes' =>$ventes,
                'clients' =>$clients,
                'numeroFacture'=>$numeroFacture,
                'montant' => $recus->montant_recu,
            ]
        );
        
        return $pdf->stream($numeroFacture);
    }

    public function render()
    {
        return view('livewire.ventes');
    }
}
