<?php

namespace App\Models\Old\Eolis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    use HasFactory;

    protected $connection = 'eolis';
    protected $table = 'employe';
    protected $primaryKey = 'code_emp';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [];
    protected $hidden = ['photo', 'signature'];
}
