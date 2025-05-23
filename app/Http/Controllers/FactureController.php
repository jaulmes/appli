<?php

namespace App\Http\Controllers;

use App\Models\facture;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FactureController extends Controller
{
    public function factureVente(){
        $factures = facture::whereHas('ventes')->with('ventes')->get();
        return view('factures.ventes', compact('factures'));
    }

    public function afficherFactureVente($id){
        $factures = facture::with('ventes.produits')->find($id);

        $ventes = $factures->ventes;
        //dd($factures);
        $netAPayer = $ventes->montantTotal - $ventes->reduction;
        
        if($ventes->packs->count() > 0){
            // chrger les donnee sur la facture pour avoyer sur une vue qui sera converti en pdf
            $pdf = Pdf::loadView('factures.afficherFactureVentePacks',[
                'ventes' =>$ventes,
                'netAPayer' => $netAPayer,
                'factures' => $factures,
            ]);
        }else{
            // chrger les donnee sur la facture pour avoyer sur une vue qui sera converti en pdf
            $pdf = Pdf::loadView('factures.afficherFactureVentes',[
                'ventes' =>$ventes,
                'netAPayer' => $netAPayer,
                'factures' => $factures,
            ]);
        }
        
           
        return $pdf->stream($factures->numeroFacture.'.pdf');
    }
    

    public function telechargerFactureVente($id){
        $factures = facture::find($id);
        $ventes = $factures->ventes;
        $netAPayer = $ventes->montantTotal - $ventes->reduction;

        if($ventes->packs->count() > 0){
            // chrger les donnee sur la facture pour avoyer sur une vue qui sera converti en pdf
            $pdf = Pdf::loadView('factures.afficherFactureVentePacks',[
                'ventes' =>$ventes,
                'netAPayer' => $netAPayer,
                'factures' => $factures,
            ]);
        }else{
            // chrger les donnee sur la facture pour avoyer sur une vue qui sera converti en pdf
            $pdf = Pdf::loadView('factures.afficherFactureVentes',[
                'ventes' =>$ventes,
                'netAPayer' => $netAPayer,
                'factures' => $factures,
            ]);
        }

        
           
        return $pdf->download($factures->numeroFacture.'.pdf');
    }

    public function factureInstallation(){
        $factures = facture::whereHas('installations')->with('installations')->get();
        //dd($factures->installations->created_at);
        return view('factures.installations', compact('factures'));
    }

    public function afficherFactureInstallation($id){
        $factures = facture::with('installations.produits')->find($id);

        $installations = $factures->installations;
        $netAPayer = $installations->montantTotal - $installations->reduction;


        if($installations->packs->count() > 0){
        // chrger les donnee sur la facture pour envoyer sur une vue qui sera converti en pdf
        $pdf = Pdf::loadView('factures.afficherFactureInstallationPacks',[
            'installations' =>$installations,
            'netAPayer' => $netAPayer,
            'factures' => $factures,
        ]);
        }else{
        // chrger les donnee sur la facture pour envoyer sur une vue qui sera converti en pdf
        $pdf = Pdf::loadView('factures.afficherFactureInstallations',[
            'installations' =>$installations,
            'netAPayer' => $netAPayer,
            'factures' => $factures,
        ]);
        }

        
           
        return $pdf->stream($factures->numeroFacture.'.pdf');
    }

    public function telechargerFactureInstallation($id){
        $factures = facture::find($id);
        $installations = $factures->installations;
        $netAPayer = $installations->montantTotal - $installations->reduction;

        // chrger les donnee sur la facture pour avoyer sur une vue qui sera converti en pdf
        $pdf = Pdf::loadView('factures.afficherFactureInstallations',[
            'installations' =>$installations,
            'factures' => $factures,
            'netAPayer' => $netAPayer,
        ]);
        
           
        return $pdf->download($factures->numeroFacture.'.pdf');
    }

    public function afficherFactureProformat($id){
        $factures = facture::with('proformats.produits')->find($id);

        $proformats = $factures->proformats;
        $netAPayer = $proformats->montantTotal - $proformats->reduction;

        // chrger les donnee sur la facture pour envoyer sur une vue qui sera converti en pdf
        $pdf = Pdf::loadView('factures.afficherProformats',[
            'proformats' =>$proformats,
            'netAPayer' => $netAPayer,
            'factures' => $factures,
        ]);
        
           
        return $pdf->stream($factures->numeroFacture.'.pdf');
    }
}
