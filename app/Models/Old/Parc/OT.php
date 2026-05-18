<?php

namespace App\Models\Old\Parc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OT extends Model
{
    use HasFactory;

    protected $table = 'ordtrav';
    protected $primaryKey = 'idot';
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'parc';
    
    protected $fillable = [];
}
