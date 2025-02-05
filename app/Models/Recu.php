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
        'transaction_id',
        'charge_id',
        'user_id',
        'client_id',
        'montant_recu',
        'remarque'

    ];

    public function clients(){
        return $this->belongsTo(Client::class);
    }

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
        return $this->belongsTo(Installation::class);
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
}
