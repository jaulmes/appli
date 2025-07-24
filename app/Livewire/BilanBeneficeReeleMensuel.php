<?php

namespace App\Livewire;

use App\Models\Charge;
use App\Models\Installation;
use App\Models\Vente;
use Carbon\Carbon;
use Livewire\Component;

class BilanBeneficeReeleMensuel extends Component
{

    public $moisSelectionne, $totalCharge, $totalVente, $totalAchatVente,
            $totalInstallation, $totalAchatInstallation;
    public $beneficeReele, $beneficeBrute;
    public $charges, $ventes, $installations;

    public function afficher(){
        //montant total des charges
        $this->charges = Charge::whereYear('created_at', Carbon::parse($this->moisSelectionne)->year)
                        ->whereMonth('created_at', Carbon::parse($this->moisSelectionne)->month)
                        ->latest()
                        ->get();

        $this->totalCharge = $this->charges->sum('montant');

        //Benefice reel sur les ventes des produits
        $this->ventes = Vente::whereYear('created_at', Carbon::parse($this->moisSelectionne)->year)
            ->whereMonth('created_at', Carbon::parse($this->moisSelectionne)->month)
            ->latest()
            ->get();

        foreach ($this->ventes as $vente) {
            //calculer le montant total du prix d'achat et de ventes des produits vendus
            foreach ($vente->produits as $produit) {
                $this->totalVente += $produit->pivot->quantity * $produit->pivot->price;
                $this->totalAchatVente += $produit->pivot->quantity * $produit->prix_achat;
            }
        }

        //Benefice reel sur les installations
        $this->installations = Installation::whereYear('created_at', Carbon::parse($this->moisSelectionne)->year)
            ->whereMonth('created_at', Carbon::parse($this->moisSelectionne)->month)
            ->latest()
            ->get();
        foreach ($this->installations as $installation) {
            //calculer le montant total des installations
            foreach ($installation->produits as $produit) {
                $this->totalInstallation += $produit->pivot->quantity * $produit->pivot->price;
                $this->totalAchatInstallation += $produit->pivot->quantity * $produit->prix_achat;
            }
        }

        //Calculer le benefice brut
        $this->beneficeBrute = ($this->totalVente + $this->totalInstallation) - 
                               ($this->totalAchatVente + $this->totalAchatInstallation);

        //Calculer le benefice reel
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
