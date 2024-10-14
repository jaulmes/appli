<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'telephone',
        'localisation'
    ];

    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'fournisseur_produit')
                    ->withPivot('price');
    }
}
