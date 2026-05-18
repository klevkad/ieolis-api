<?php

namespace App\Policies\Old\Eolis;

use App\Models\Old\Eolis\Facentet;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FacentetPolicy
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
        return $user->hasPermissionTo('facentetindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\Facentet  $facentet
     * @return mixed
     */
    public function view(User $user, Facentet $facentet)
    {
        return $user->hasPermissionTo('facentetshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('facentetcreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\Facentet  $facentet
     * @return mixed
     */
    public function update(User $user, Facentet $facentet)
    {
        return $user->hasPermissionTo('facentetupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\Facentet  $facentet
     * @return mixed
     */
    public function delete(User $user, Facentet $facentet)
    {
        return $user->hasPermissionTo('facentetdelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Facentet  $facentet
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Facentet $facentet)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Facentet  $facentet
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Facentet $facentet)
    {
        //
    }
}
