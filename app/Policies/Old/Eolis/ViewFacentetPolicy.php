<?php

namespace App\Policies\Old\Eolis;

use App\Models\Old\Eolis\View_Facentet;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ViewFacentetPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('factureindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\View_Facentet  $viewFacentet
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, View_Facentet $viewFacentet)
    {
        return $user->hasPermissionTo('factureshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('facturecreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\View_Facentet  $viewFacentet
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, View_Facentet $viewFacentet)
    {
        return $user->hasPermissionTo('factureupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\View_Facentet  $viewFacentet
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, View_Facentet $viewFacentet)
    {
        return $user->hasPermissionTo('facturedelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\View_Facentet  $viewFacentet
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, View_Facentet $viewFacentet)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\View_Facentet  $viewFacentet
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, View_Facentet $viewFacentet)
    {
        //
    }
}
