<?php

namespace App\Models\Old\Eolis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bls extends Model
{
    use HasFactory;

    protected $table = 'bls';
    protected $primaryKey = 'idbl';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'eolis';
    
    protected $fillable = [];
    protected $appends = [];
//    protected $with = ['documents'];

    public function documents()
    {
        return $this->hasMany(View_Document::class,'nodocument','nobl');
    }
}
