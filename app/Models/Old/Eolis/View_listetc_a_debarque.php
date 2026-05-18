<?php

namespace App\Models\Old\Eolis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View_listetc_a_debarque extends Model
{
    use HasFactory;

    protected $table = 'view_listetc_a_debarque';
    protected $primaryKey = 'idprev_debarq';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'eolis';
    
    protected $fillable = [];

   
}
