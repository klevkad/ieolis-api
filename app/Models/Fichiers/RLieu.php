<?php

namespace App\Models\Fichiers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RLieu extends Model
{
    use HasFactory;

    protected $table = 'r_lieu';
    protected $primaryKey = 'idlieu';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'booking';

    protected $fillable = [
        'lib_lieu',
    ];

}
