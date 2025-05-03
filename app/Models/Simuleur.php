<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simuleur extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'client_simuleur_id',
        'numero',
        'adresse',
        'email'
    ];
    public function simulations()
    {
        return $this->hasMany(Simulation::class, 'simuleur_id');
    }
    public function clientSimuleur()
    {
        return $this->belongsTo(ClientSimuleur::class, 'client_simuleur_id');
    }
}
