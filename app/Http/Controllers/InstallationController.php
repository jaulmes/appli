<?php

namespace App\Http\Controllers;

use App\Models\Installation;
use Illuminate\Http\Request;

class InstallationController extends Controller
{
    public function ajouterPaiement($id){
        $installations = Installation::find($id);
        return view('installations.ajouterPaiement', compact('installations'));
    }
    public function index(){
        $installations = Installation::all();
        return view('installations.index', compact('installations'));
    }
    
}
