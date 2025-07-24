<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suivi extends Model
{
    use HasFactory;
        protected $fillable = [
        'user_id',
        'client_id',
        'conclusion'
    ];

    public function transactions(){
        return $this->hasOne(Transaction::class, 'suivi_id');
    }

    public function clients(){
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function users(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function besoins(){
        return $this->hasMany(BesoinParticulier::class, 'suivi_id');
    }

    public function observations(){
        return $this->hasMany(Observation::class, 'suivi_id');
    }
}
