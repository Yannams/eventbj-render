<?php

namespace App\Policies;

use App\Models\evenement;
use App\Models\Intervenant;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class IntervenantPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Intervenant $intervenant): bool
    {
        //
    }

    public function index(User $user, evenement $evenement)
    {
        return $evenement->profil_promoteur_id==$user->Profil_promoteur->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Intervenant $intervenant): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Intervenant $intervenant): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Intervenant $intervenant): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Intervenant $intervenant): bool
    {
        //
    }
}
