<?php

namespace App\Models\Old\Eolis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'client';
    protected $primaryKey = 'code_cli';
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'eolis';

/*
    const CREATED_AT = 'date_creation';
    const UPDATED_AT = 'date_modification';
*/

    protected $fillable = [
    ];

}
