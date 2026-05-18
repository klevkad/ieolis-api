<?php

namespace App\Models\Old\Acconage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compteur extends Model
{
    use HasFactory;

    protected $table = 't_compteur';
    protected $primaryKey = 'numcompteur';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'acconage';

    protected $appends = [
        'nbrepriselibre'
    ];
    protected $casts = [
        'typeprise' => 'integer'
    ];
    protected $fillable = [];
    protected $with = [];

    public function getNbrepriselibreAttribute()
    {
        return $this->nbreprise - $this->branchementactifs()->count();
    }

    public function branchementactifs()
    {
        return $this->hasMany(Branchement::class, 'numcompteur', 'numcompteur')->whereNull('heurfinbranch');
    }

    public function releveindex()
    {
        return $this->hasMany( ReleveIndexCompteur::class, 'numcompteur', 'numcompteur')->orderBy('datereleve','desc');
    }

    public function lastreleveindex()
    {
        return $this->hasMany(ReleveIndexCompteur::class, 'numcompteur', 'numcompteur')->orderBy('datereleve','desc')->limit(10);
    }

}
