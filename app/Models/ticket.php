<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ticket extends Model
{
    use HasFactory;
      
    protected $fillable = ['code_QR'] ;

    public function type_ticket():BelongsTo
    {
        return $this->belongsTo(type_ticket::class);
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
