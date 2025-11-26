<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoldeCompteMensuel extends Model
{
    use HasFactory;
    protected $fillable = [
        'compte_id',
        'date_capture',
        'solde_fin',
        'solde_debut',
    ];

    public function compte()
    {
        return $this->belongsTo(Compte::class);
    }
}
