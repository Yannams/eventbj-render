<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class evenement extends Model
{
    use HasFactory;

    protected $fillable = ['nom_evenement','localisation','localisation_maps', 'date_heure_debut','date_heure_fin','description','cover_event','isOnline','administrative_status','Fréquence','etat','raison','	recommanded','Etape_creation','cover_recommanded'];

    public function type_lieu():BelongsTo
    {
        return $this->belongsTo(type_lieu::class);
    }

    public function type_evenement():BelongsTo
    {
        return $this->belongsTo(type_evenement::class);
    }

    public function type_tickets():HasMany
    {
        return $this->hasMany(type_ticket::class);
    }

    public function users():BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('like','nombre_click','date_click','date_like','date_unlike','created_at','updated_at');
    }

    public function profil_promoteur():BelongsTo
    {
        return $this->belongsTo(Profil_promoteur::class);
    }

    public function intervenants():HasMany
    {
        return $this->hasMany(intervenant::class);
    }

    public function centre_interets():BelongsToMany
    {
        return $this->belongsToMany(Centre_interet::class)->withPivot('created_at','updated_at');;
    }

    public function controleurs():BelongsToMany
    {
        return $this->belongsToMany(Controleur::class)->withPivot('name','telephone','email');
    }

    public function verifications():HasMany
    {
        return $this->hasMany(tickets_verifications::class);
    }

    public function chronogrammes():HasMany
     {
        return $this->hasMany(chronogramme::class);
     }
}
