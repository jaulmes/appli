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
        'NetAPayer',
        'montantVerse',
        'reduction',
        'statut',
        'date',
        'impot',
        'auteur',
        'totalAchat',
        'moiEncour',
        'commission',
        'agentOperant'
    ] ;

    public function user()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
    
    public function compte()
    {
        return $this->belongsTo(Compte::class);
    }

    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'produit_vente')
                            ->withPivot('quantity', 'price');
    }

    public function factures()
    {
        return $this->hasOne(facture::class);
    }

    public function recus(){
        return $this->hasMany(Recu::class);
    }

    public function clients(){
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function transactions(){
        return $this->hasOne(Vente::class);
    }
}
