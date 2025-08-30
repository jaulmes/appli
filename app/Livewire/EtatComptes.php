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
        // ✅ 1. Solde avant le mois (toutes les transactions antérieures)
        $transactionsAvantMois = $compte->transactions()
            ->where('created_at', '<', $debutMois)
            ->get();

        $montantInitial = $transactionsAvantMois->sum(function ($t) {
            $typesPositifs = ['depot', 'recu', 'ajout_fonds', 'remboursement'];
            $typesNegatifs = ['Achat', 'charge', 'virement', 'BonCommande', 'retrait', 'paiement'];

            if (in_array($t->type, $typesPositifs)) {
                return $t->montantVerse;
            } elseif (in_array($t->type, $typesNegatifs)) {
                return -$t->montantVerse;
            }
            return 0;
        });

        // ✅ 2. Solde final (toutes les transactions jusqu’à la fin du mois)
        $transactionsJusquaFinMois = $compte->transactions()
            ->where('created_at', '<=', $finMois)
            ->get();

        $montantFinal = $transactionsJusquaFinMois->sum(function ($t) {
            $typesPositifs = ['depot', 'recu', 'ajout_fonds', 'remboursement'];
            $typesNegatifs = ['Achat', 'charge', 'virement', 'BonCommande', 'retrait', 'paiement'];

            if (in_array($t->type, $typesPositifs)) {
                return $t->montantVerse;
            } elseif (in_array($t->type, $typesNegatifs)) {
                return -$t->montantVerse;
            }
            return 0;
        });

        // ✅ 3. Résultats
        $resultats[] = [
            'compte'          => $compte->nom,
            'mois'            => $this->moisSelectionne,
            'montant_initial' => $montantInitial,
            'montant_final'   => $montantFinal,
            'variation'       => $montantFinal - $montantInitial, // optionnel
        ];
    }

    $this->resultats = $resultats;
}


    public function render()
    {
        return view('livewire.etat-comptes', [
            'resultats' => $this->resultats
        ]);
    }
}
