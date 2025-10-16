<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AchatPaiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'achat_id',
        'compte_id',
        'montant',
        'date',
        'user_id'
    ];
    
    public function transactions(){
        return $this->hasOne(Transaction::class);
    }
    public function achats(){
        return $this->belongsTo(Achat::class);
    }
    public function comptes(){
        return $this->belongsTo(Compte::class);
    }
    public function users(){
        return $this->belongsTo(User::class);
    }
}
