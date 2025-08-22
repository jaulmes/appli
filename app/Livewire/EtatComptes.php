<?php

namespace App\Livewire;

use App\Models\Compte;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EtatComptes extends Component
{
    public $moisSelectionne;  
    public $resultats = [];

    public function mount($moi)
    {
        $this->moisSelectionne = $moi;
        $this->afficher();
    }

    public function afficher()
    {
        $comptes = Compte::all();
        $resultats = [];

        // Conversion du mois sélectionné en date
        $debutMois = Carbon::parse($this->moisSelectionne . '-01')->startOfMonth();
        $finMois   = Carbon::parse($this->moisSelectionne . '-01')->endOfMonth();

        foreach ($comptes as $compte) {
            // Solde avant le mois
            if ($compte->transactions()->where('created_at', '<', $debutMois)->exists()) {
                $transactionsAvantMois = $compte->transactions()
                    ->where('created_at', '<', $debutMois)
                    ->get(); // récupère une collection

                $montantInitial = $transactionsAvantMois->sum(function($t){
                    $typesPositifs = ['credit', 'ajout_fonds', 'remboursement'];
                    $typesNegatifs = ['Achat', 'retrait', 'paiement'];

                    // si type credit -> +montant, si debit -> -montant
                    return $t->type === 'Achat' ? $t->montant : -$t->montant;
                });
                dd($montantInitial);
            } else {
                $montantInitial = 0; // Si aucune transaction avant le mois, solde initial est 0
            }
            // $montantInitial = $compte->whereHas('created_at', '<', $debutMois)
            //                             ->sum('montant');
            
            dd($montantInitial, $compte);

            // Solde jusqu'à la fin du mois
            $montantFinal = Transaction::where('compte_id', $compte->id)
                ->where('created_at', '<=', $finMois)
                ->sum('montant');

            $resultats[] = [
                'compte' => $compte->nom,
                'mois' => $this->moisSelectionne,
                'montant_initial' => $montantInitial,
                'montant_final' => $montantFinal,
            ];
        }

        $this->resultats = $resultats;
    }

    public function render()
    {
        return view('livewire.etat-compte-mensuel', [
            'resultats' => $this->resultats
        ]);
    }
}
