<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use ParagonIE\Sodium\Core\Curve25519\H;

class CallMomoApiController extends Controller
{
    public function index(){
        Http::withHeaders([]);
        return Http::dd()->get('https://sandbox.momodeveloper.mtn.com/collection/v1_0/requesttopay');
    }

    public function apiUserForm (){
        return view('momoapi');
    }

    //api to create new user api
    public function apiUser(){
        Http::withHeaders([
            'X-Reference-Id' => '869db613-9497-40de-9d8f-26b264fe2c5f',
        ])
        ->post('https://sandbox.momodeveloper.mtn.com/v1_0/apiuser');

        return response()->json([
            'message' => 'User created successfully'
        ], 200);
    }

    //api to get api user information
    public function userInfo(){
        return dd(Http::withHeaders([
            'X-Reference-Id' => '869db613-9497-40de-9d8f-26b264fe2c5f',
        ])->get('https://sandbox.momodeveloper.mtn.com/v1_0/apiuser/869db613-9497-40de-9d8f-26b264fe2c5f'));
    }

}
