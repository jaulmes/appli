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

    public function recus(){
        return $this->hasMany(Recu::class);
    }
    public function installations(){
        return $this->hasMany(Installation::class);
    }
    public function ventes(){
        return $this->hasMany(Vente::class);
    }
    public function proformats(){
        return $this->hasMany(Proformat::class);
    }
    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
}
