<?php

namespace App\Models\Old\Eolis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compte_Tiers extends Model
{
    use HasFactory;

    protected $table = 'compte_tiers';
    protected $primaryKey = 'no_cpte_tiers';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'eolis';

}
