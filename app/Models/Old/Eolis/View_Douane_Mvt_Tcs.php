<?php

namespace App\Models\Old\Eolis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View_Douane_Mvt_Tcs extends Model
{
    use HasFactory;

    protected $table = 'view_douane_mvt_tcs';
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'eolis';
    
    protected $fillable = [];
}
