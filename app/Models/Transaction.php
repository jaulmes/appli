<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable=[
        'date',
        'heure',
        'nomClient',
        'numeroClient',
        'type',
        'moi',
        'impot',
        'montantVerse',
        'user_id',
        'compte_id'
    ];

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
        return $this->belongsToMany(Produit::class)
                    ->withPivot('quantity', 'price');
    }
}
