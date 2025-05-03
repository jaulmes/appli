<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simulation extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'simuleur_id',
        'client_simuleur_id',
    ];

    public function simuleur()
    {
        return $this->belongsTo(Simuleur::class, 'simuleur_id'); 
    }
    public function clientSimuleur()
    {
        return $this->belongsTo(ClientSimuleur::class, 'client_simuleur_id');
    }
    public function appareils(){
        return $this->hasMany(AppareilSimulation::class);
    }
}
