<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class type_ticket extends Model
{
    use HasFactory;

    protected $fillable = ['image_ticket', 'nom_ticket', 'prix_ticket','frais_ticket', 'place_dispo'] ;

    public function evenement():BelongsTo
    {
        return $this->belongsTo(evenement::class);
    }
    
    public function tickets():HasMany
    {
        return $this->hasMany(ticket::class);
    }
}
