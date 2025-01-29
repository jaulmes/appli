<?php

namespace App\Livewire;

use App\Models\facture;
use Livewire\Component;
use Livewire\WithPagination;

class Factures extends Component
{
    public $factures;
    public $type = 'ventes';

    public function mount(){
        $this->chargerFacture();
    }

    public function Ventes(){
        $this->type = "ventes";
        $this->chargerFacture();
    }

    public function Intallations(){
        $this->type = "installations";
        $this->chargerFacture();
    }
    public function chargerFacture(){
        
        if($this->type == "ventes"){
            $this->factures = facture::whereHas('ventes')
                                    ->with('ventes')
                                    ->orderBy('created_at', 'asc')
                                    ->get();
        }
        elseif($this->type == "installations"){
            $this->factures = facture::whereHas('installations')
            ->with('installations')
            ->orderBy('created_at', 'asc')
            ->get();
        }
        
    }

    public function render()
    {
        return view('livewire.factures');
    }
}
