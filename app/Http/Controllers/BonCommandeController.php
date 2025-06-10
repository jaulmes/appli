<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BonCommandeController extends Controller
{
    public function index()
    {

        return view('bonCommandes.index');
    }
}
