<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'produit_id',
        'quantity',
        'prix_total',
        'status',
        'date_commande'
    ];
    public function clients()
    {
        return $this->belongsTo(Client::class);
    }
    public function produits()
    {
        return $this->belongsToMany(Produit::class)
            ->withPivot('quantity', 'price');
    }
    public function transactions()
    {
        return $this->hasOne(Transaction::class);
    }
    public function ventes()
    {
        return $this->hasMany(Vente::class);
    }

}
