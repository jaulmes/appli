<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Compte;
use App\Models\Installation as ModelsInstallation;
use App\Models\Recu;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Installation extends Component
{
    public $installations = [];
    public $query;
    public $client_id;
    public $clients = [];
    public $comptes = [];
    public $compte_id;
    public $remarque;
    public $montant;

    public function mount(){
        $this->installations = ModelsInstallation::all();
        $this->clients = Client::all();
        $this->comptes = Compte::all();
    }

    //ajouter un paiement
    public function ajouterPaiement(Request $request, $id){
        $installations = ModelsInstallation::find($id);
        //dd($installations->clients->name);
        $recus = new Recu();
        $transactions = new Transaction();
        $comptes = Compte::find($this->compte_id);

        $recus->user_id = Auth::user()->id;
        $recus->installation_id = $installations->id;
        $recus->compte_id = $this->compte_id;
        if($installations->client_id){
            $recus->client_id = $installations->client_id;
        }else{
            $recus->client_id = $this->client_id;
            $installations->client_id = $this->client_id;
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
        $installations->montantVerse = $installations->montantVerse + $this->montant;
        if($installations->NetAPayer > $installations->montantVerse ){
            $installations->statut = "non termine";
            $installations->dateLimitePaiement = '';
        }
        else{
            $installations->statut = "termine";
        }
        $recus->save();
        $comptes->montant = $comptes->montant + $recus->montant_recu;
        $comptes->save();
        $installations->save();
        $transactions->recu_id = $recus->id;
        $transactions->type = "recu";
        $transactions->save();
        //dd($transactions, $comptes, $recus, $installations);
        
        // chrger les donnee sur la facture pour avoyer sur une vue qui sera converti en pdf
        $pdf = Pdf::loadView('recus.installation_pdf',
            [
                'installation' =>$installations,
                'clients' =>$clients,
                'numeroFacture'=>$numeroFacture,
                'montant' => $recus->montant_recu,
            ]
        );
        
        return $pdf->stream($numeroFacture);
    }
    //recherche
    public function update_search(){
        $this->installations = ModelsInstallation::where('nomClient', 'like', '%'. $this->query .'%')
                                                   ->orWhere('numeroClient', 'like', '%'. $this->query .'%')
                                                   ->get();
    }
    public function render()
    {
        return view('livewire.installation');
    }
}
