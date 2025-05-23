<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pack extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'prix',
        'image',
    ];

    public function commandes()
    {
        return $this->belongsToMany(commande::class, )
            ->withPivot('quantity', 'prix');
    }

    public function installations()
    {
        return $this->belongsToMany(Installation::class, 'pack_installation')
                    ->withPivot('quantity', 'prix');
    }

    public function ventes()
    {
        return $this->belongsToMany(Vente::class, 'pack_vente')
                    ->withPivot('quantity', 'prix');
    }
    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'produit_pack')
                    ->withPivot('quantity', 'price');
    }
}
