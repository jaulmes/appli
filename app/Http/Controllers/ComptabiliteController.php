<?php

namespace App\Http\Controllers;

use App\Models\Compte;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComptabiliteController extends Controller
{
    public function index(){
        $comptes = Compte::all();
        return view('comptes.index', compact('comptes'));
    }

    public function create(){
        return view('comptes.create');
    }

    public function store(Request $request){
        $comptes = new Compte();
        $comptes->nom = $request->nom;
        $comptes->numero = $request->numero;
        $comptes->montant = $request->montant;

        $comptes->save();
        return redirect()->route('dashboard.compte', [ 'comptes'=>$comptes ]);
    }
    
    public function edit($id){
        $comptes = Compte::find($id);
        return view('comptes.edit', compact('comptes'));
    }
    
    public function update(Request $request, $id){
        $comptes = Compte::find($id);

        $comptes->nom = $request->nom;
        $comptes->numero = $request->numero;
        $comptes->montant = $request->montant;
        $comptes->save();
        return redirect()->route('dashboard.compte', $comptes);
    }
    
    public function delete($id)
    {
        Compte::where('id', $id)->delete();
        session()->flash("message", "Vous avez supprime ce compte avec succes!");
        return redirect()->route('dashboard.compte');
    }
    public function transfert(){
        $comptes = Compte::all();
        return view('comptes.transfert', [
            'comptes'=>$comptes
        ]);
    }

    //fonction pour valider es transfert entre compte
    public function valider_transfert(Request $request){
        //recuperer le compte envoyeur
        $envoyeur = Compte::find($request->envoyeur_id);
        $solde_envoyeur = $envoyeur->montant;

        //recuperer le compte receveur
        $receveur = Compte::find($request->receveur_id);
        $solde_receveur = $receveur->montant;

        //recuperer le montant a envoyer
        $montant_tranferer = $request->montant;
        
        //verifier que le monant dans le compte envoyeur est supperieur a 0
        if($solde_envoyeur <= 0 ){
            return redirect()->back()->with('error', 'ATTENTION!! fond insuffisant dans le compte '. $envoyeur->nom .' veuillez recharger le compte ou choisir un autre compte');
        }
        //verifier que le montant a transferer est supperieur a celui present dans le compte a transferer
        elseif($montant_tranferer > $solde_envoyeur ){
            return redirect()->back()->with('error', 'ATTENTION!! le montant a transferer est supperieur a celui present dans le compte '. $envoyeur->nom);
        }
        //verifier que le montant a transferer est > 0
        elseif($montant_tranferer <= 0 ){
            return redirect()->back()->with('error', 'ATTENTION!! le montant a transferer ne peut pas etre null');
        }
        //verifier que les comptes sont differents
        elseif($envoyeur == $receveur ){
            return redirect()->back()->with('error', 'ATTENTION!! les comptes doivent etre different');
        }

        //soustraire le montant transfere du solde envoyeur
        $envoyeur->montant = $solde_envoyeur - $montant_tranferer;

        //ajouter le montant transfere dans le solde receveur
        $receveur->montant = $solde_receveur + $montant_tranferer;

        //valider le transfer en tant que transaction
        $dateHeure = now();
        $moi = now()->month;

        $transactions = new Transaction();
        $transactions->date = $dateHeure->format('Y-m-d');
        $transactions->moi = $moi;
        $transactions->heure = $dateHeure->format('H:i:s');
        $transactions->type = 'transfert';
        $transactions->impot = $request->impot;
        $transactions->montantVerse = $request->montant;
        $transactions->user_id = Auth::user()->id;
        
        

        $transactions->save();
        $envoyeur->save();
        $receveur->save();

        return redirect()->back()->with('message', 'transfert effectue avec succes!!');
    }

}
