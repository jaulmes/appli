<?php

namespace App\Livewire;

use App\Models\Achat;
use App\Models\Charge;
use App\Models\Installation;
use App\Models\Vente;
use Carbon\Carbon;
use Livewire\Component;

class BilanBeneficeReeleMensuel extends Component
{
    public $moisSelectionne;
    public $totalCharge = 0, $totalVente = 0, $totalAchatVente = 0;
    public $totalInstallation = 0, $totalAchatInstallation = 0, $montantInvesti = 0;
    public $beneficeReele = 0, $beneficeBrute = 0;

    public $charges = [], $ventes = [], $installations = [];

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

        // Calcul bénéfices
        $this->beneficeBrute = ($this->totalVente + $this->totalInstallation)
            - ($this->totalAchatVente + $this->totalAchatInstallation);

        $this->beneficeReele = $this->beneficeBrute - $this->totalCharge;
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
