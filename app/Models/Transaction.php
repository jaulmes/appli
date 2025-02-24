<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable=[
        'date',
        'heure',
        'nomClient',
        'numeroClient',
        'type',
        'moi',
        'impot',
        'montantVerse',
        'user_id',
        'compte_id',
        'recu_id'
    ];

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
        return $this->belongsToMany(Produit::class)
                    ->withPivot('quantity', 'price');
    }
    public function recus(){
        return $this->belongsTo(Recu::class);
    }
    public function charges():BelongsTo
    {
        return $this->belongsTo(Charge::class, 'charge_id');
    }
    public function chargesDetails(): BelongsTo
    {
        return $this->belongsTo(ChargeDetail::class, 'chargeDetail_id');
    }
}
