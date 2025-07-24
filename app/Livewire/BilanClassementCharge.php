<?php

namespace App\Livewire;

use App\Models\Charge;
use Carbon\Carbon;
use Livewire\Component;

class BilanClassementCharge extends Component
{
    public $moisSelectionne;
    public $charges;
    public $total;

    public function mount($moi)
    {
        $this->moisSelectionne = $moi;
        $this->afficher();
    }

    public function afficher()
    {
        $this->charges = Charge::whereYear('created_at', Carbon::parse($this->moisSelectionne)->year)
                        ->whereMonth('created_at', Carbon::parse($this->moisSelectionne)->month)
                        ->latest()
                        ->get();

        $this->total = $this->charges->sum('montant');
    }
    public function render()
    {
        return view('livewire.bilan-classement-charge');
    }
}
