<?php

namespace App\Models\Old\Eolis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View_Eolis_Mvt_Tcs extends Model
{
    use HasFactory;

    protected $table = 'view_eolis_mvt_tcs';
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'eolis';
    
    protected $fillable = [];
}
