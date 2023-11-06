<?php

namespace App\Models;

use App\Models\evenement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class type_evenement extends Model
{
    use HasFactory;

    protected $fillable = ['nom_type_evenement','description'];
    public function evenements():HasMany
    {
        return $this->hasMany(evenement::class);
    }
    
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
}
