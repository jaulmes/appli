<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Charge;
use App\Models\Vente;
use App\Models\Achat;
use App\Models\Compte;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $currentMonth = $request->input('month', Carbon::now()->format('Y-m'));
        $transactions = Transaction::whereMonth('created_at', Carbon::parse($currentMonth)->month)
                           ->whereYear('created_at', Carbon::parse($currentMonth)->year)
                           ->orderBy('created_at', 'desc')
                           ->with('produits')
                           ->paginate(10);


        
        return view('transactions.index', compact('transactions', 'currentMonth' ));
    }
    
    public function bilan(Request $request){
        
        //je recupere le moi en cour dans le formulaire
        $currentMonth = $request->input('month', Carbon::now()->format('Y-m'));
        
        //je recuper les ventes du moi en cour
        $ventes = Vente::whereMonth('created_at', Carbon::parse($currentMonth)->month)
                        ->whereYear('created_at', Carbon::parse($currentMonth)->year)
                        ->get();
                        
        //je recupere les charge du moi en cour
        $charges = Charge::whereMonth('created_at', Carbon::parse($currentMonth)->month)
                        ->whereYear('created_at', Carbon::parse($currentMonth)->year)
                        ->get();
                        
        //je recupere les charge du moi en cour
        $achats = Achat::whereMonth('created_at', Carbon::parse($currentMonth)->month)
                        ->whereYear('created_at', Carbon::parse($currentMonth)->year)
                        ->get();

        //je fais la somme du montant verse par les client(l'argent entrant)
        $chiffreAffaire = $ventes->sum('montantVerse');
        
        //je recupere le montant total des charges du moi en cours
        $montantCharge = $charges->sum('montant');
        
        //je fais la somme des prix d'achats des produits vendus
        $montantAchat = $ventes->sum('totalAchat');
        
        //je fais la somme du prix d'achat des produits achete dans le moi(investissement)
        $investissement = $achats->sum('total');
        
        //j'affiche les benefices sur les ventes
        $benefices = $ventes->sum('montantVerse') - $ventes->sum('totalAchat') - $ventes->sum('reduction');
        return view('transactions.bilan', compact('chiffreAffaire', 'montantCharge', 'montantAchat', 'investissement', 'benefices'));
    }

    //recuperer 
    public function filter(Request $request)
    {
        if($request->month){
            $moi = $request->month;
        }
        else{
            $moi = now()->format('m/y');
        }
        
        $transactions = Transaction::where('moi', $moi)->get();

        //dd($transactions);
    
        return view('transactions.mensuelle', compact('transactions'));
    }

    /**
     * afficher les transactions de l'utilisateur connecté
     */
    public function mesTransactions(Request $request)
    {

        $currentMonth = $request->input('month', Carbon::now()->format('Y-m'));

        $userId= Auth::user()->id;

        $transactions = Transaction::where('user_id', $userId)
                                    ->whereMonth('created_at', Carbon::parse($currentMonth)->month)
                                    ->whereYear('created_at', Carbon::parse($currentMonth)->year)
                                    ->orderBy('created_at', 'desc')
                                    ->with('produits')
                                    ->get();
        
        return view('transactions.mesTransactions', compact('transactions', 'currentMonth'));
    }
    



    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
