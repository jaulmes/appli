<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'image',
        'status'
    ];

    public function annonces()
    {
        return $this->hasMany(Annonce::class, 'service_id');
    }
}
