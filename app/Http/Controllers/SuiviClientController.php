<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuiviClientController extends Controller
{
    public function index(){
        return view('suiviClients.index');
    }

    public function show($id){
        return view('suiviClients.show', ['id' => $id]);
    }
}
