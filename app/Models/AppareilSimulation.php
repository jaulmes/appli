<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppareilSimulation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'power',
        'quantity',
        'duration',
        'simulation_id'
    ];

    public function simulations(){
        return $this->belongsTo(Simulation::class, 'simulation_id');
    }
}
