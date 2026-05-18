<?php

namespace App\Models\Old\Parc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatterieEtat extends Model
{
    use HasFactory;

    protected $connection = 'parc';
    protected $table = 'batterieetats';
    protected $fillable = [
        'libelle',
        'enabled'
    ];
}
