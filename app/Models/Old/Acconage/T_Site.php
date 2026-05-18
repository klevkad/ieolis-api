<?php

namespace App\Models\Old\Acconage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T_Site extends Model
{
    use HasFactory;

    protected $table = 't_site';
    protected $primaryKey = 'id_site';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'acconage';

    

}
