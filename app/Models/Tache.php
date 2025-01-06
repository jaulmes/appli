<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tache extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre',
        'description',
        'statut',//termine ou nom
        'etat',//attribue ou nom
        'date_debut',
        'date_fin',
        'assigned_to',
        'created_by'
    ];

    public function createur(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assigne(){
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function commentaires(){
        return $this->hasMany(Commentaire::class);
    }


}
