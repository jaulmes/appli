<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecusController extends Controller
{
    public function index(){
        return view('recus.index');
    }
}
