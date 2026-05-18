<?php

namespace App\Policies\Export;

use App\Models\Export\RetourTc;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RetourTcPolicy
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
        return $user->hasPermissionTo('retourtcindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\RetourTc  $retourTc
     * @return mixed
     */
    public function view(User $user, RetourTc $retourTc)
    {
        return $user->hasPermissionTo('retourtcshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('retourtccreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\RetourTc  $retourTc
     * @return mixed
     */
    public function update(User $user, RetourTc $retourTc)
    {
        return $user->hasPermissionTo('retourtcupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\RetourTc  $retourTc
     * @return mixed
     */
    public function delete(User $user, RetourTc $retourTc)
    {
        return $user->hasPermissionTo('retourtcdelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\RetourTc  $retourTc
     * @return mixed
     */
    public function restore(User $user, RetourTc $retourTc)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\RetourTc  $retourTc
     * @return mixed
     */
    public function forceDelete(User $user, RetourTc $retourTc)
    {
        //
    }
}
