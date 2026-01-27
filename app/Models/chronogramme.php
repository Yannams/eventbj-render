<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class chronogramme extends Model
{
    use HasFactory;

    protected $fillable = ["heure_debut","heure_fin","date_activite","nom_activite","evenement_id"];

    public function evenement():BelongsTo
    {
        return $this->belongsTo(evenement::class);
    }
}
