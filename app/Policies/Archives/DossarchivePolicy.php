<?php

namespace App\Policies\Archives;

use App\Models\Archives\Dossarchive;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DossarchivePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('dossarchiveindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\Dossarchive  $dossarchive
     * @return mixed
     */
    public function view(User $user, Dossarchive $dossarchive)
    {
        return $user->hasPermissionTo('dossarchiveshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('dossarchivecreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\Dossarchive  $dossarchive
     * @return mixed
     */
    public function update(User $user, Dossarchive $dossarchive)
    {
        return $user->hasPermissionTo('dossarchiveupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\Dossarchive  $dossarchive
     * @return mixed
     */
    public function delete(User $user, Dossarchive $dossarchive)
    {
        return $user->hasPermissionTo('dossarchivedelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Archives\Dossarchive  $dossarchive
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Dossarchive $dossarchive)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Archives\Dossarchive  $dossarchive
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Dossarchive $dossarchive)
    {
        //
    }
}
