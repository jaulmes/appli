<?php

namespace App\Http\Controllers;

use App\Models\Compte;
use App\Models\Produit;
use App\Models\User;
use App\Models\Vente;
use Illuminate\Http\Request;
use DB;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class DashboardController extends Controller
{
    public function index(){
        //afficher une estimation du prix total des prix de vente, achat et prix technicien des produit disponible
        $total_achat = 0;
        $total_technicien = 0;
        $total_vente = 0;

        //total prix des produits disponible
        $total_achat = Produit::where('stock', '>', 0)->sum('prix_achat');
        $total_technicien = Produit::where('stock', '>', 0)->sum('prix_technicien');
        $total_vente = Produit::where('stock', '>', 0)->sum('price');
        
        //formatage des prix
        $total_achat_formate = number_format($total_achat, 0, ',', ' ') . '   Francs CFA';
        $total_technicien_formate = number_format($total_technicien, 0, ',', ' ') . '   Francs CFA';
        $total_vente_formate = number_format($total_vente, 0, ',', ' ') . '   Francs CFA';


        $argent = Compte::sum('montant');
        $montant = number_format($argent, 0, ',', ' ') . '   Francs CFA';

        $moi = now()->format('m-Y');
        
        $montantVente = Vente::where('dateEncour', $moi)->sum('montantTotal');
                             
        
        //afficher les benefices
        $montantAchat = Vente::where('dateEncour', $moi)->sum('totalAchat');
        
        //formate le montant des benefice
        $benefice = $montantVente - $montantAchat;
        $benefice_formate = number_format($benefice, 0, ',', ' ') . '   Francs CFA';

        $user = FacadesAuth::user();
        $unreadNotifications = $user->unreadNotifications ->count();
        


        return view('dashboard.index', compact('montant', 'total_achat_formate', 'total_technicien_formate', 'total_vente_formate', 'benefice_formate', 'user', 'unreadNotifications'));
    }
    

}
