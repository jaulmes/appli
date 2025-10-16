<?php

namespace App\Livewire;

use App\Models\Achat;
use App\Models\AchatPaiement;
use App\Models\Compte;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ModalAddPaiementAchat extends Component
{
    public $achat;
    public $comptes, $montantVerse, $modePaiement;

    public function ajouterPaiement(){
        DB::beginTransaction();
        try {
            //dd($this->montantVerse);
            //verification
            $validate = $this->validate([
                'montantVerse' => 'required|numeric',
                'modePaiement' => 'required',
            ],[
                'montantVerse.required' => 'Veuillez entrer le montant versé',
                'montantVerse.numeric' => 'Le montant versé doit être un nombre',
                'modePaiement.required' => 'Veuillez selectionner le mode de paiement',
            ]);
            $comptes = Compte::find( $this->modePaiement);
            if(!$comptes){
                return redirect()->back()->with('error', 'Veuillez selectionner un compte');
            }
            $achat = $this->achat;
            $achats = Achat::find($achat->id);

            if(!$achats){
                return redirect()->back()->with('error', 'Achat introuvable');
            }

            if(!$this->montantVerse){
                return redirect()->back()->with('error', 'Veuillez entrer le montant versé');
            }

            if($this->montantVerse <= 0){
                return redirect()->back()->with('error', 'Le montant versé doit être superieur à 0');
            }
            if($this->montantVerse > $achats->total - $achats->montantVerse){
                return redirect()->back()->with('error', 'Le montant versé ne doit pas depasser le montant restant à payer');
            }

            if($this->montantVerse > $comptes->montant){
                return redirect()->back()->with('error', 'Le montant dans le compte est insufisant');
            }

            $achatPaiement = new AchatPaiement();
            $achatPaiement->achat_id = $achats->id;
            $achatPaiement->compte_id = $comptes->id;
            $achatPaiement->montant = $this->montantVerse;
            $achatPaiement->user_id = Auth::user()->id;
            $achatPaiement->save();

            $achats->montantVerse += $this->montantVerse;
            if($achats->montantVerse >= $achats->total){
                $achats->statut = 'termine';
            } else {
                $achats->statut = 'non termine';
            }
            
            $dateHeure = now();

            //enregistrement transaction
            $transactions = new Transaction();
            $transactions->date = $dateHeure->format('d/m/y');
            $transactions->heure = $dateHeure->format('H:i:s');
            $transactions->type = 'Ajout paiement achat';
            $transactions->compte_id = $comptes->id;
            $transactions->user_id = Auth::user()->id;
            $transactions->achat_id = $achats->id;

            $comptes->montant = $comptes->montant - $this->montantVerse;
            
            $transactions->save();
            
            $comptes->save();
            $achats->save();
            DB::commit();
            return redirect()->route('achats.index')->with('message', 'achat enregistré avec succes');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'enregistrement du paiement: ' . $e->getMessage());
        }
    }
    public function mount($achat){
        $this->achat = $achat;
        $this->comptes = Compte::all();
    }
    public function render()
    {
        return view('livewire.modal-add-paiement-achat');
    }
}
