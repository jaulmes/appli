<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proformat extends Model
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
        'impot',
        ];
        
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'produit_proformats')
                            ->withPivot('quantity', 'price');
    }

    public function factures()
    {
        return $this->hasOne(facture::class);
    }

    public function clients(){
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function transactions(){
        return $this->hasOne(Transaction::class);
    }
}
