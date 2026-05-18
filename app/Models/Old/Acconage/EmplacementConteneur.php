<?php

namespace App\Models\Old\Acconage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmplacementConteneur extends Model
{
    use HasFactory;

    protected $table = 'emplacement_conteneur';
    protected $primaryKey = 'idemplacement';
    protected $keyType = 'string';
    public $incrementing = true;
    public $timestamps = true;
    protected $connection = 'acconage';

    protected $fillable = ['idemplacement', 'no_tc','id_site','last_posit', 'codeuser', 'created_at','updated_at'];
    
    public function site()
    {
        return $this->hasOne(T_Site::class, 'id_site', 'id_site');
    }
    public function tcsbase()
    {
        return $this->hasOne('App\Models\Old\Eolis\TcsBase', 'no_tc', 'no_tc');
    }

    // public function emplacementconteneurs()
    // {
    //     return $this->hasMany(TcsBase::class, 'no_tc', 'no_tc');
    // }

}
