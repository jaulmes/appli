<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compte extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'numero',
        'montant'
    ];

    public function bonCommandes()
    {
        return $this->hasMany(BonCommande::class);
    }

    public function produits(){
        return $this->belongsToMany(Produit::class, 'compte_produit')
                    ->withPivot('montant');
    }

    public function achat()
    {
        return $this->hasMany(Achat::class);
    }
    
    public function vente()
    {
        return $this->hasMany(Vente::class);
    }

    public function recus(){
        return $this->hasMany(Recu::class);
    }
}
