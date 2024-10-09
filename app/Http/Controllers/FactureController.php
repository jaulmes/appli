<?php

namespace App\Http\Controllers;

use App\Models\facture;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FactureController extends Controller
{
    public function factureVente(){
        $factures = facture::all();
        return view('factures.ventes', compact('factures'));
    }

    public function afficherFactureVente($id){
        $factures = facture::with('ventes.produits')->find($id);

        $ventes = $factures->ventes;
        $netAPayer = $ventes->montantTotal - $ventes->reduction;

        // chrger les donnee sur la facture pour envoyer sur une vue qui sera converti en pdf
        $pdf = Pdf::loadView('factures.afficherFactureVentes',[
            'ventes' =>$ventes,
            'netAPayer' => $netAPayer,
            'factures' => $factures,
        ]);
        
           
        return $pdf->stream($factures->numeroFacture);
    }

    public function telechargerFactureVente($id){
        $factures = facture::find($id);
        $ventes = $factures->ventes;
        $netAPayer = $ventes->montantTotal - $ventes->reduction;

        // chrger les donnee sur la facture pour avoyer sur une vue qui sera converti en pdf
        $pdf = Pdf::loadView('factures.afficherFactureVentes',[
            'ventes' =>$ventes,
            'netAPayer' => $netAPayer,
            'factures' => $factures,
        ]);
        
           
        return $pdf->download($factures->numeroFacture);
    }
}
