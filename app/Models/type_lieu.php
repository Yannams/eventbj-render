<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class type_lieu extends Model
{
    use HasFactory;

    protected $fillable = ['nom_type','description'];

    public function evenements():BelongsToMany
    {
        return $this->belongsToMany(evenement::class);
    }
}
