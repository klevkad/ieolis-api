<?php

namespace App\Models\Old\Parc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Typengin extends Model
{
    use HasFactory;

    protected $table = 'typengin';
    protected $primaryKey = 'codetype';
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'parc';
    protected $keyType = 'string';
    
    protected $fillable = [];

    public function engins()
    {
        return $this->hasMany(Engin::class,'codetype','codetype')->orderBy('idengin');
    }
}
