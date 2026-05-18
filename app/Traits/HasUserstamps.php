<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait HasUserstamps
{
    /**
     * Handle the model "creating" event.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function creating(Model $model)
    {
        if( is_null($model->created_by) )
        {
            $model->created_by = Auth::id();
        }

        if( is_null($model->created_by) )
        {
            $model->updated_by = Auth::id();
        }
    }

    /**
     * Handle the model "updating" event.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function updating(Model $model)
    {
        $model->updated_by = Auth::id();
    }

    /**
     * Handle the model "deleting" event.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function deleting(Model $model)
    {
        if( is_null($model->deleted_by) )
        {
            $model->deleted_by = Auth::id();
        }
    }

    /**
     * Handle the model "restoring" event.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function restoring(Model $model)
    {
        $model->deleted_by = null;
    }

    /**
     * Handle the model "force deleted" event.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function forceDeleted(Model $model)
    {
        //
    }
}