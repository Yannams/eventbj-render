<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'profil_user',
        'name',
        'username',
        'email',
        'num_user', 
        'isPromoteur',
        'isEntreprise',
        'password',
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

   
    public function tickets():HasMany
    {
        return $this->hasMany(ticket::class);
    }

    public function evenements():BelongsToMany
    {
        return $this->belongsToMany(evenement::class)->withPivot('like','nombre_click','date_click','date_like','date_unlike','created_at','updated_at');
    }

    public function Profil_promoteur():HasOne
    {
        return $this->hasOne(Profil_promoteur::class);
    }

    public function Controleur():HasOne
    {
        return $this->hasOne(Controleur::class);
    }

    public function intervenants():HasMany
    {
        return $this->hasMany(Intervenant::class);
    }

    public function centre_interets():BelongsToMany
    {
        return $this->belongsToMany(Centre_interet::class)->withPivot('created_at','updated_at');
    }
}
