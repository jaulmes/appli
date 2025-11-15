<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productImage extends Model
{
    use HasFactory;
        protected $fillable = [
        'produit_id',
        'path',
        'is_gif',
        
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}
