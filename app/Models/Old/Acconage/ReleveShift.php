<?php

namespace App\Models\Old\Acconage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReleveShift extends Model
{
    use HasFactory;

    protected $table = 'releve_shift';
    protected $primaryKey = 'lib_shift';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'acconage';

    protected $appends = [];
    protected $fillable = [];
    protected $with = [];

}
