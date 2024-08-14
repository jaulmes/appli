<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installation extends Model
{
    use HasFactory;
    
    Protected $fillable = [
        'montantProduit',
        'mainOeuvre',
        'montantVerse',
        'reduction',
        'nomClient',
        'numeroClient',
        'qteTotal',
        'agentOperant',
        'commission',
        'impot'
        ];
        
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function compte()
    {
        return $this->belongsTo(Compte::class);
    }
}
