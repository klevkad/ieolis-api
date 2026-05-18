<?php

namespace App\Policies\Old\Parc;

use App\Models\Old\Parc\BatterieType;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BatterieTypePolicy
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
        return $user->hasPermissionTo('batterietypeindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\BatterieType  $batterieType
     * @return mixed
     */
    public function view(User $user, BatterieType $batterieType)
    {
        return $user->hasPermissionTo('batterietypeshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('batterietypecreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\BatterieType  $batterieType
     * @return mixed
     */
    public function update(User $user, BatterieType $batterieType)
    {
        return $user->hasPermissionTo('batterietypeupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\BatterieType  $batterieType
     * @return mixed
     */
    public function delete(User $user, BatterieType $batterieType)
    {
        return $user->hasPermissionTo('batterietypedelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\BatterieType  $batterieType
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, BatterieType $batterieType)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\BatterieType  $batterieType
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, BatterieType $batterieType)
    {
        //
    }
}
