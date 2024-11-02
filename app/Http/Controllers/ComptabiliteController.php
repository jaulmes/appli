<?php

namespace App\Http\Controllers;

use App\Models\Compte;
use Illuminate\Http\Request;

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

}
