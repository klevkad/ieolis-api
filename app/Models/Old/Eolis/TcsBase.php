<?php

namespace App\Models\Old\Eolis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TcsBase extends Model
{
    use HasFactory;

    protected $table = 'tcs_base';
    protected $primaryKey = 'no_tc';
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'eolis';
    
    protected $fillable = [];
}
