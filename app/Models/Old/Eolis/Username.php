<?php

namespace App\Models\Old\Eolis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Username extends Model
{
    use HasFactory;

    protected $connection = 'eolis';
    protected $table = 'username';
    protected $primaryKey = 'codeuser';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [];
    protected $hidden = [
        'motdepass',
    ];

    protected $with = ['employe'];

    public function employe()
    {
        return $this->belongsTo(Employe::class, 'code_emp', 'code_emp', 'eolis.employe');
    }

    public function user()
    {
        return $this->morphOne('App\Models\User','model');
    }

}
