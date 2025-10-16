<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'numero'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $guard_name = 'web';

    public function achatsPaiements()
    {
        return $this->hasMany(AchatPaiement::class);
    }
    
    public function suivis(){
        return $this->hasMany(Suivi::class);
    }

    public function bonCommandes()
    {
        return $this->hasMany(BonCommande::class);
    }

    //relation avec celui qui a cree la tache
    public function createurTache(){
        return $this->hasMany(Tache::class, 'created_by');
    }

    //relation avec celui a qui on a assigne la tache
    public function assigneTache(){
        return $this->hasMany(Tache::class, 'assigned_to');
    }

    public function commentaires(){
        return $this->hasMany(Commentaire::class);
    }

    public function recus(){
        return $this->hasMany(Recu::class);
    }

    public function proformats(){
        return $this->hasMany(Proformat::class);
    }
}
