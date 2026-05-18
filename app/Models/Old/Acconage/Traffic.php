<?php

namespace App\Models\Old\Acconage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traffic extends Model
{
    use HasFactory;

    protected $table = 'traffic';
    protected $primaryKey = 'idtraffic';
//    protected $keyType = 'string';
    public $incrementing = true;
//    public $timestamps = false;
    protected $connection = 'acconage';

    protected $appends = [];
    protected $fillable = [];
    protected $with = [];
}
