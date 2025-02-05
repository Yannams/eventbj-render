<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Profil_promoteur extends Model
{
    use HasFactory;

    protected $fillable=['nom','type_organisateur'];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function evenements(): HasMany
    {
        return $this->hasMany(evenement::class);
    }

    public function controleurs(): HasMany
    {
        return $this->hasMany(Controleur::class);
    }
}
