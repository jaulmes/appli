<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonCommande extends Model
{
    use HasFactory;

    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'bon_commande_produit')
                    ->withPivot('quantite', 'prix_unitaire');
    }

    public function comptes()
    {
        return $this->belongsTo(Compte::class);
    }
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
