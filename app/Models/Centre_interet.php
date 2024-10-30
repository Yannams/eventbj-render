<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Centre_interet extends Model
{
    use HasFactory;

    protected $fillable=["nom_ci"];

    public function users():BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('created_at','updated_at');
    }

    public function evenements():BelongsToMany
    {
        return  $this->belongsToMany(evenement::class)->withPivot('created_at','updated_at');
    }
}
