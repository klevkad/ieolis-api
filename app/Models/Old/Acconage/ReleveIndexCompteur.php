<?php

namespace App\Models\Old\Acconage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReleveIndexCompteur extends Model
{
    use HasFactory;

    protected $table = 't_releve_index_compteur';
    protected $primaryKey = 'idt_releve_index_compteur';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'acconage';

    protected $fillable = [
        'numcompteur',
        'numsemaine',
        'nummois',
        'numjour',
        'datereleve',
        'indexdebut',
        'indexfin',
        'consojrnl',
        'numerodumois',
        'pourcenteolis',
        'consoeolis',
        'consosmpa',
        'datesaisie',
        'codeuser',
    ];

    protected $with = ['compteur'];

    public function getNextAttribute()
    {
        return ReleveIndexCompteur::where('indexdebut',$this->indexfin)->where('numcompteur',$this->numcompteur)->first();
    }

    public function compteur()
    {
        return $this->hasOne(Compteur::class, 'numcompteur', 'numcompteur');
    }

}
