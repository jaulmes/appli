<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Charge;
use App\Models\ChargeDetail;
use App\Models\Compte;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ChargeController extends Controller
{
    public function index(){
        $charges= Charge::orderBy('created_at', 'desc')->get();

        return view('charge.index', compact('charges'));
    }

    public function create(){
        $comptes = Compte::all();
        return view('charge.create', compact('comptes'));
    }

    public function store(Request $request){
        $charges= new Charge();

        $charges->titre = $request->input('titre');
        $charges->montant = $request->input('montant');
        $charges->date = $request->input('date');
        
        $comptes = Compte::where('id', $request->compte_id)->first();
        $comptes->montant = $comptes->montant - $charges->montant;
        
        //enregistrement transaction
        $transactions = new Transaction();
        $dateHeure = now();
        
        $transactions->date = $request->input('date');
        $date = $request->input('date');
        
        $moi = \Carbon\Carbon::parse($date)->format('m');
        $transactions->moi = $moi;
        $transactions->heure = $dateHeure->format('H:i:s');
        $transactions->type = 'charge';
        $transactions->compte_id = $request->compte_id;
        $transactions->impot = $request->impot;
        $transactions->montantVerse = $request->input('montant');
        $transactions->user_id = Auth::user()->id;
        
        dd($charges);
        $transactions->save();
        $charges->save();
        $comptes->save();
        return Redirect::route('charges.index')->with('success', 'nouvelle charge ajouté!');
    }

    public function add($id){
        $charges = Charge::find($id);
        $comptes = Compte::all();
        return view('charge.ajouter', compact('charges', 'comptes'));
    }

    public function addDetail(Request $request, $id)
    {
        $charges = Charge::find($id);
        $chargeDetail = new chargeDetail();

        $chargeDetail->charge_id = $charges->id;
        $chargeDetail->date = $request->input('date');
        $chargeDetail->titre = $request->input('titre');
        $chargeDetail->montant = $request->input('montant');
        $chargeDetail->detail = $request->input('detail');

        $total = $charges->montant + $chargeDetail->montant;
        $charges->montant = $total;

        //enregistrement transaction
        $transactions = new Transaction();
        $dateHeure = now();
        
        $transactions->date = $request->input('date');
        $date = $request->input('date');
        
        $moi = \Carbon\Carbon::parse($date)->format('m');
        $transactions->moi = $moi;
        $transactions->heure = $dateHeure->format('H:i:s');
        $transactions->type = 'charge';
        $transactions->compte_id = $request->compte_id;
        $transactions->impot = $request->impot;
        $transactions->montantVerse = $request->input('montant');
        $transactions->user_id = Auth::user()->id;
        
        

        $moi = now()->month;
        
        $comptes = Compte::where('id', $request->compte_id)->first();
        
        $comptes->montant = $comptes->montant - $chargeDetail->montant;

        $transactions->save();
        $comptes->save();
        $chargeDetail->save();
        $charges->save();

        return view('charge.sousCharge', compact('charges'));

    }

    public function showChargeDetail($id){
        $charges = Charge::with('chargeDetail')->find($id);
        //$charges = chargeDetail::where('charge_id', $id);
        //dd($charges);


        return view('charge.sousCharge', compact('charges'));
    }
}
