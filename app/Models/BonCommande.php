<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonCommande extends Model
{
    use HasFactory;
    protected $fillable = [
        'compte_id',
        'montant',
        'titre',
        'user_id',
        'date_livraison',
        'date_commande',
        'status',
        'frais'
    ];

    public function transactions(){
        return $this->hasOne(Transaction::class);
    }

    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'bon_commande_produit')
                    ->withPivot('quantity', 'price');
    }

    public function comptes()
    {
        return $this->belongsTo(Compte::class, 'compte_id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
