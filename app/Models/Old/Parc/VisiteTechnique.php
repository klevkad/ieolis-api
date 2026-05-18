<?php

namespace App\Models\Old\Parc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisiteTechnique extends Model
{
    use HasFactory;

    protected $table = 'visite_technique';
    protected $primaryKey = 'idvisite_technique';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'parc';
//    protected $keyType = 'string';
    
    protected $fillable = [];
}
