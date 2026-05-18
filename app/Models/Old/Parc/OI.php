<?php

namespace App\Models\Old\Parc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OI extends Model
{
    use HasFactory;

    protected $table = 'ordre_interv';
    protected $primaryKey = 'code_interv';
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'parc';
    protected $keyType = 'string';
    
    protected $fillable = [];

    public function operationtechniques()
    {
        return $this->belongsToMany(OperationTechnique::class,'tache_intervention','code_interv','idoperation_technique');
    }

    public function pieces()
    {
        return $this->belongsToMany(Piece::class,'pieces_intervention','code_interv','idpiece')->withPivot(['qtepiece']);
    }
}
