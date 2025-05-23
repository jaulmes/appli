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
        'impot',
        'NetAPayer',
        'dateLimitePaiement'
        ];

    public function packs()
    {
        return $this->belongsToMany(Pack::class, 'pack_installation')
                            ->withPivot('quantity', 'prix');
    }
        
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
        return $this->belongsToMany(Produit::class, 'installation_produit')
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
        return $this->hasOne(Transaction::class);
    }
}
