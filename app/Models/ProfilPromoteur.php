<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfilPromoteur extends Model
{
    use HasFactory;

    protected $fillable=['nom','type_organisateur'];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
