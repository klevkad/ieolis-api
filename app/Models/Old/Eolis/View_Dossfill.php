<?php

namespace App\Models\Old\Eolis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View_Dossfill extends Model
{
    use HasFactory;

    protected $table = 'view_dossfill';
    protected $primaryKey = 'no_dossfille';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'eolis';

    protected $fillable = [];
    protected $appends = [];

    public function bl()
    {
        return $this->belongsTo(Bls::class,'idbl','idbl');
    }

}
