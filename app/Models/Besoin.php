<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Besoin extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'client_id',
        'conclusion',
        'prochain_rendez_vous'
    ];

    protected $casts = [
        'prochain_rendez_vous' => 'datetime',
    ];

    public function clients(){
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function users(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
