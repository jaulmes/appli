<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Realisation extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'descriptions',
        'date',
        'img1',
        'img2',
        'img3',
        'img4',
        'img5'
    ];
}
