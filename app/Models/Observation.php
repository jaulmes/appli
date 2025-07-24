<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observation extends Model
{
    use HasFactory;
    protected $fillable = [
        'resume',
        'besoin_id'
    ];

    public function suivis(){
        return $this->belongsTo(Suivi::class, 'besoin_id');
    }
}
