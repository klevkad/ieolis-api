<?php

namespace App\Models\Old\Acconage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompteurEau extends Model
{
    use HasFactory;

    protected $table = 't_compteur_eau';
    protected $primaryKey = 'numcpteur';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'acconage';

    protected $appends = [];
    protected $fillable = [];
    protected $with = [];

    public function releveindex()
    {
        return $this->hasMany(ReleveIndexEau::class, 'numcpteur', 'numcpteur')->orderBy('datereleve','desc');
    }

    public function lastreleveindex()
    {
        return $this->hasMany(ReleveIndexEau::class, 'numcpteur', 'numcpteur')->orderBy('datereleve','desc')->limit(10);
    }

}
