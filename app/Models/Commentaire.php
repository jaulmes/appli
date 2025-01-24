<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'tache_id',
        'user_id',
        'commentaire',
    ];
    
    public function users(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function taches(){
        return $this->belongsTo(Tache::class);
    }
}
