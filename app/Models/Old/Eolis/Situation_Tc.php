<?php

namespace App\Models\Old\Eolis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Situation_Tc extends Model
{
    use HasFactory;

    protected $table = 'situation_tc';
    protected $primaryKey = 'idsituation_tc';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'eolis';
    
    protected $fillable = [];
}
