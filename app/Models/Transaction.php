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

    public function ventes(){
        return $this->belongsTo(Vente::class, 'vente_id');
    }

    public function installations(){
        return $this->belongsTo(Installation::class, 'installation_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function compte()
    {
        return $this->belongsTo(Compte::class);
    }

    //pour afficher les produits lie au vente achat et aux installations
    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'produit_transaction')
                    ->withPivot('quantity', 'price', 'name');
    }
    public function recus(){
        return $this->belongsTo(Recu::class, 'recu_id');
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
