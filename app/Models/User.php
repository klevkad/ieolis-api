<?php

namespace App\Models;

use App\Models\Old\Eolis\Operateu;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'home',
        'homemobile',
        'email',
        'password',
        'ct_num',
        'enabled',
        'change_password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'model_id',
        'model_type',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = ['roles'];
    protected $appends = ['operateurs'];

    public function getOperateursAttribute()
    {
        return Operateu::whereIn('code_cli',$this->ct_nums->pluck('ct_num')->concat([$this->ct_num]))->get();
    }

    public function AauthAcessToken()
    {
        return $this->hasMany('App\Models\OauthAccessToken');
    }

    public function ct_nums()
    {
        return $this->hasMany(UserFcomptet::class, 'user_id');
    }

/*
    public function operateurs()
    {
        return $this->belongsToMany(Operateu::class, 'user_fcomptet', 'user_id', 'ct_num', 'id', 'code_cli');
    }
*/

    public function model()
    {
        return $this->morphTo();
    }

    public function isUsername()
    {
        return $this->model_type == 'App\Models\Old\Eolis\Username';
    }

}


class UserFcomptet extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'booking';
    protected $table = 'user_fcomptet';
    protected $fillable = ['ct_num'];
}
