<?php

namespace App\Models\Old\Parc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assurance extends Model
{
    use HasFactory;

    protected $table = 'assurance';
    protected $primaryKey = 'idassurance';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'parc';
    protected $keyType = 'string';
    
    protected $fillable = [];
}
