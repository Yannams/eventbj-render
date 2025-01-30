<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany; 
use Illuminate\Database\Eloquent\SoftDeletes;

class type_ticket extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['image_ticket', 'nom_ticket', 'prix_ticket', 'place_dispo','format','texte','lien','event_link','methodeProgrammationLancement','Date_heure_lancement','methodeProgrammationFermeture','Date_heure_fermeture'] ;

    public function evenement():BelongsTo
    {
        return $this->belongsTo(evenement::class);
    }
    
    public function tickets():HasMany
    {
        return $this->hasMany(ticket::class);
    }
}
