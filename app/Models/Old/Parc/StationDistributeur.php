<?php

namespace App\Models\Old\Parc;

use Illuminate\Database\Eloquent\Model;

class StationDistributeur extends Model
{
    protected $table = 'station_distributeur';
    public $timestamps = false;
    protected $connection = 'parc';
}
