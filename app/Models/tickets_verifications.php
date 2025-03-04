<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class tickets_verifications extends Model
{
    use HasFactory;

    protected $fillable=['statut','nom_controleur','num_controleur','mail_controleur','ticket_id','controleur_id','evenement_id','profil_promoteur_id'];

    public function controleur():BelongsTo
    {
        return $this->belongsTo(Controleur::class);
    } 
     public function ticket():BelongsTo
    {
        return $this->belongsTo(ticket::class);
    } 

    public function evenement():BelongsTo
    {
        return $this->belongsTo(evenement::class);
    }

    public function profil_promoteur():BelongsTo
    {
        return $this->belongsTo(Profil_promoteur::class);
    }
}
