<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BesoinParticulier extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'besoin_id'
    ];

    public function suivis()
    {
        return $this->belongsTo(Suivi::class, 'suivi_id');
    }
}
