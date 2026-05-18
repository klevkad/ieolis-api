<?php

namespace App\Models\Old\Parc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatterieType extends Model
{
    use HasFactory;

    protected $connection = 'parc';
    protected $table = 'batterietypes';
    protected $fillable = [
        'libelle',
        'enabled'
    ];
}
