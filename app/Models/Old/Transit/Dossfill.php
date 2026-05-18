<?php

namespace App\Models\Old\Transit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dossfill extends Model
{
    use HasFactory;

    protected $table = 'dossfill';
    protected $primaryKey = 'no_dossfille';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'transit';

    protected $fillable = [];
    protected $appends = [];

}
