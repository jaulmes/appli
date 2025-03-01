<?php

namespace App\Http\Controllers;

use App\Models\Recu;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RecusController extends Controller
{
    public function afficherInstallation($id){
        $recus = Recu::with('installations.clients')->find($id);
        
        if($recus->installation_id){
            return $pdf = Pdf::loadView('recus.installation_pdf',
                                        [
                                            'recus' => $recus
                                        ])
                                        ->setPaper([0, 0, 220, 450], 'landscape')
                                        ->stream();
        }else{
            return $pdf = Pdf::loadView('recus.vente_pdf',
            [
                'recus' => $recus
            ])
            ->setPaper([0, 0, 220, 450], 'landscape')
            ->stream();
        }
        

    }

    public function afficherVentes($id){
        $recus = Recu::find($id);
        
        return $pdf = Pdf::loadView('recus.installation_pdf',
                    [
                        'recus' => $recus
                    ])
                    ->setPaper([0, 0, 220, 450], 'landscape')
                    ->stream();
    }

    public function index(){
        return view('recus.index');
    }
}
