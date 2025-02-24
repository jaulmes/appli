<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recu extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_recu',
        'vente_id',
        'installation_id',
        'compte_id',
        'charge_id',
        'user_id',
        'client_id',
        'montant_recu',
        'remarque' //represente plustot la raison
    ];



    public function users(){
        return $this->belongsTo(User::class);
    }

    public function charges(){
        return $this->belongsTo(Charge::class);
    }

    public function ventes(){
        return $this->belongsTo(Vente::class);
    }

    public function installations(){
        return $this->belongsTo(Installation::class, 'installation_id');
    }

    public function comptes(){
        return $this->belongsTo(Compte::class);
    }

    public function transactions(){
        return $this->hasOne(Transaction::class);
    }

    public function agents(){
        return $this->belongsTo(Agent::class);
    }

    public function clients(){
        return $this->belongsTo(Client::class);
    }
}
