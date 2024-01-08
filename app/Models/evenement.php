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

    protected $fillable = ['nom_evenement','localisation', 'date_heure_debut','date_heure_fin','description','cover_event'];

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

}
