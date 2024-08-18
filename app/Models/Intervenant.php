<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Intervenant extends Model
{
    use HasFactory;

    public function profil_promoteur():BelongsTo
    {
        return $this->belongsTo(Profil_promoteur::class);
    }

    public function evenement():BelongsTo
    {
        return $this->belongsTo(evenement::class);
    }
}
