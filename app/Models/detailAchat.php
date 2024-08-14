<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detailAchat extends Model
{
    use HasFactory;

    protected $fillable = [
        'achat_id',
        'produit_id',
        'quantite',
        'prixUnitaire',
        'total',
    ];


    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id', 'id');
    }

    public function achat()
    {
        return $this->belongsTo(Achat::class, 'achat_id', 'id');
    }
}
