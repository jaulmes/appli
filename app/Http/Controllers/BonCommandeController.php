<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BonCommandeController extends Controller
{
    public function index()
    {
        return view('bonCommandes.index');
    }

    public function create(){
        return view('bonCommandes.create');
    }
}
