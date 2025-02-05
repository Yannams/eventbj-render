<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Controleur extends Model
{
    use HasFactory;

    protected $fillable = ['ControleurId','statut','user_id','profil_promoteur_id'];

    public function User():HasOne
    {
        return $this->hasOne(User::class);
    }

    public function profil_promoteur():BelongsTo
    {
        return $this->belongsTo(Profil_promoteur::class);
    }

    public function evenements():BelongsToMany
    {
        return $this->belongsToMany(evenement::class)->withPivot('name','telephone','email','statut_affectation','created_at','updated_at');
    }
}
