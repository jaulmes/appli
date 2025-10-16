<?php

namespace App\Livewire;

use App\Models\Achat;
use App\Models\Charge;
use App\Models\Installation;
use App\Models\Recu;
use App\Models\Transaction;
use App\Models\Vente;
use Carbon\Carbon;
use Livewire\Component;

class BilanBeneficeReeleMensuel extends Component
{
    public $moisSelectionne;
    public $totalCharge = 0, $totalVente = 0, $totalAchatVente = 0;
    public $totalInstallation = 0, $totalAchatInstallation = 0, $montantInvesti = 0;
    public $beneficeReele = 0, $beneficeBrute = 0;

    public $charges = [], $ventes = [], $installations = [], 
            $recu = [], $chiffreAffaire = 0;

    public function afficher()
    {
        $date = Carbon::parse($this->moisSelectionne);

        // ✅ Réinitialisation à chaque affichage
        $this->reset(['totalCharge', 'totalVente', 'totalAchatVente', 'totalInstallation', 'totalAchatInstallation', 'montantInvesti', 'beneficeBrute', 'beneficeReele']);

        // Charges
        $this->charges = Charge::whereYear('created_at', $date->year)
            ->whereMonth('created_at', $date->month)
            ->latest()
            ->get();

        $this->totalCharge = collect($this->charges)->sum('montant');

        // Ventes
        $this->ventes = Vente::whereYear('created_at', $date->year)
            ->whereMonth('created_at', $date->month)
            ->with('produits') // ✅ optimisation pour éviter N+1
            ->latest()
            ->get();

        foreach ($this->ventes as $vente) {
            foreach ($vente->produits as $produit) {
                $this->totalVente += $produit->pivot->quantity * $produit->pivot->price;
                $this->totalAchatVente += $produit->pivot->quantity * $produit->prix_achat;
            }
        }

        // Installations
        $this->installations = Installation::whereYear('created_at', $date->year)
            ->whereMonth('created_at', $date->month)
            ->with('produits')
            ->latest()
            ->get();

        foreach ($this->installations as $installation) {
            foreach ($installation->produits as $produit) {
                $this->totalInstallation += $produit->pivot->quantity * $produit->pivot->price;
                $this->totalAchatInstallation += $produit->pivot->quantity * $produit->prix_achat;
            }
        }

        // Investissements
        $achats = Achat::whereYear('created_at', $date->year)
            ->whereMonth('created_at', $date->month)
            ->get();

        $this->montantInvesti = $achats->sum('total');

        //produit ajoute avec une quantite > 0
        $produit_achat = Transaction::whereYear('created_at', $date->year)
            ->whereMonth('created_at', $date->month)
            ->where('type', 'achat')
            ->get();

        $this->montantInvesti += $produit_achat->sum('montantVerse');
        // Calcul bénéfices
        $this->beneficeBrute = ($this->totalVente + $this->totalInstallation)
            - ($this->totalAchatVente + $this->totalAchatInstallation);

        $this->beneficeReele = $this->beneficeBrute - $this->totalCharge;

        //chiffre d'affaire
        $montantVente = 0;
        $this->ventes = Vente::whereYear('created_at', Carbon::parse($this->moisSelectionne)->year)
                        ->whereMonth('created_at', Carbon::parse($this->moisSelectionne)->month)
                        ->latest()
                        ->get();
        
        foreach($this->ventes as $vente){
            $montantVente += $vente->montantVerse;
        }

        $montantInstallation = 0;
        $this->installations = Installation::whereYear('created_at', Carbon::parse($this->moisSelectionne)->year)
                        ->whereMonth('created_at', Carbon::parse($this->moisSelectionne)->month)
                        ->latest()
                        ->get();
        foreach($this->installations as $installation){
            $montantInstallation += $installation->montantVerse;
        }

        $montantRecu = 0;
        $this->recu = Recu::whereYear('created_at', Carbon::parse($this->moisSelectionne)->year)
                        ->whereMonth('created_at', Carbon::parse($this->moisSelectionne)->month)
                        ->latest()
                        ->get();
        foreach($this->recu as $recus){
            $montantRecu += $recus->montant_recu;
        }
        $this->chiffreAffaire = $montantVente + $montantInstallation + $montantRecu;
    }

    public function mount($moi)
    {
        $this->moisSelectionne = $moi;
        $this->afficher();
    }

    public function render()
    {
        return view('livewire.bilan-benefice-reele-mensuel');
    }
}
