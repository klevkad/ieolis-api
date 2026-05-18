<?php

namespace App\Models\Old\Eolis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View_User extends Model
{
    use HasFactory;

    protected $table = 'view_users';

    protected $primaryKey = 'id';
//    protected $keyType = 'string';
    public $incrementing = true;
    public $timestamps = true;

    protected $connection = 'eolis';

}
