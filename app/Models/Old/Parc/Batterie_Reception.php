<?php

namespace App\Models\Old\Parc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batterie_Reception extends Model
{
    use HasFactory;

    protected $table = 'mod_docker';
    protected $primaryKey = 'matricule';
    public $incrementing = false;
    public $timestamps = false;

}
