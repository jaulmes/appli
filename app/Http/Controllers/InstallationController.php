<?php

namespace App\Http\Controllers;

use App\Models\Installation;
use Illuminate\Http\Request;

class InstallationController extends Controller
{
    public function index(){
        $installations = Installation::all();
        return view('installations.index', compact('installations'));
    }
    

}
