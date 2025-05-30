<?php

namespace App\Http\Controllers;

use App\Models\AppareilSimulation;
use App\Models\Simulation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SimulationController extends Controller
{
    public function index(){
        $simulations = Simulation::orderBy('created_at', 'asc')
                                    ->get();
        return view('simulations.index', compact('simulations'));
    }

    public function rapport($id){
        $simulations = Simulation::find($id);
        $appareils = AppareilSimulation::where('id', $simulations->id)->get();

        // Générer le PDF avec les données de simulation
        $pdf = Pdf::loadView('simulations.rapport-simulation', [
            'appareils' => $appareils,
            'simulations' => $simulations
        ]);
        return $pdf->stream();
    }
}
