<?php

namespace App\Models\Fichiers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pannes_Typengin extends Model
{
    use HasFactory;

    protected $table = 'pannes_typengin';
    protected $primaryKey = 'idpanne';
    //public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'booking';

    protected $fillable = [
        'idpanne',
        'codetype',
    ];

}
