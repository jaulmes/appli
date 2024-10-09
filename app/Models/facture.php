<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class facture extends Model
{
    use HasFactory;

    protected $fillable=[
        'numeroFacture',
        'vente_id'
    ] ;

    public function ventes(): BelongsTo
    {
        return $this->belongsTo(Vente::class, 'vente_id');
    }

}
