<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable=[
        'nom',
        'numero',
    ] ;

    public function suivis(){
        return $this->hasMany(Suivi::class);
    }
    
    public function recus(){
        return $this->hasMany(Recu::class, 'client_id');
    }
    public function installations(){
        return $this->hasMany(Installation::class);
    }
    public function ventes(){
        return $this->hasMany(Vente::class, 'client_id');
    }
    public function proformats(){
        return $this->hasMany(Proformat::class);
    }
    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
    public function commandes(){
        return $this->hasMany(commande::class);
    }
    public function produits(){
        return $this->hasMany(Produit::class);
    }
}
