<?php

namespace App\Models\Old\Parc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationTechnique extends Model
{
    use HasFactory;

    protected $table = 'operation_technique';
    protected $primaryKey = 'idoperation_technique';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'parc';
    protected $keyType = 'string';
    
    protected $fillable = [];
}
