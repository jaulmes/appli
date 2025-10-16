<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Achat extends Model
{
    use HasFactory;

    protected $fillable=[
        'qte',
        'montantTotal',
        'statut',
        'date',
        'user_id',
        'impot',
        'montantVerse'
    ] ;

    // public function produits(): BelongsToMany
    // {
    //     return $this->belongsToMany(Produit::class);
    // }

    public function transactions(){
        return $this->hasOne(Transaction::class);
    }
    public function achatsPaiements()
    {
        return $this->hasMany(AchatPaiement::class);
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
        return $this->belongsToMany(Produit::class, 'produit_achat')
                            ->withPivot('quantity', 'price');
    }
}
