<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'tache_id',
        'commentaire',
    ];

    public function employes(){
        return $this->belongsTo(Employe::class);
    }
    
    public function users(){
        return $this->belongsTo(User::class);
    }

    public function taches(){
        return $this->belongsTo(Tache::class);
    }
}
