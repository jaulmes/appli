<?php

namespace App\Livewire;

use App\Models\Recu;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Livewire\Component;

class Recus extends Component
{
    public  $recus = [];

    public function afficherDetail($id){
        $recus = Recu::find($id);
        
        return $pdf = Pdf::loadView('recus.installation_pdf',
                    [
                        'recus' => $recus
                    ])
                    ->setOption('encoding', 'utf-8')
                    ->setWarnings(false)
                    ->stream();
        //dd($pdf);

        //return $pdf->stream();
        
    }
    public function mount(){
        $this->recus = Recu::with('clients')->get();
    }
    
    public function render()
    {
        return view('livewire.recus');
    }
}
