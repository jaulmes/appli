<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'produit_id',
        'service_id',
    ];

    public function produits()
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }
    public function services()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
