<?php

namespace App\Policies\Export;

use App\Models\Export\FinRetourTc;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FinRetourTcPolicy
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
        return $user->hasPermissionTo('finretourtcindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\FinRetourTc  $finRetourTc
     * @return mixed
     */
    public function view(User $user, FinRetourTc $finRetourTc)
    {
        return $user->hasPermissionTo('finretourtcshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('finretourtccreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\FinRetourTc  $finRetourTc
     * @return mixed
     */
    public function update(User $user, FinRetourTc $finRetourTc)
    {
        return $user->hasPermissionTo('finretourtcupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\FinRetourTc  $finRetourTc
     * @return mixed
     */
    public function delete(User $user, FinRetourTc $finRetourTc)
    {
        return $user->hasPermissionTo('finretourtcdelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\FinRetourTc  $finRetourTc
     * @return mixed
     */
    public function restore(User $user, FinRetourTc $finRetourTc)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\FinRetourTc  $finRetourTc
     * @return mixed
     */
    public function forceDelete(User $user, FinRetourTc $finRetourTc)
    {
        //
    }
}
