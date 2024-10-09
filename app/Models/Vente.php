<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{
    use HasFactory;
    protected $fillable=[
        'qteTotal',
        'nomClient',
        'numeroClient',
        'montantTotal',
        'montantVerse',
        'reduction',
        'statut',
        'date',
        'impot',
        'auteur',
        'totalAchat',
        'moiEncour'
    ] ;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function compte()
    {
        return $this->belongsTo(Compte::class);
    }
    public function produits()
    {
        return $this->belongsToMany(Produit::class);
    }
}
