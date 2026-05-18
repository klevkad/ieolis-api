<?php

namespace App\Models\Old\Acconage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReleveIndexEau extends Model
{
    use HasFactory;

    protected $table = 't_releve_index_eau';
    protected $primaryKey = 'idt_releve_eau';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'acconage';

    protected $fillable = [
        'datereleve',
        'indexdebut',
        'indexfin',
        'datesaisie',
        'codeuser',
        'numcpteur',
    ];

    protected $with = ['compteur'];

    public function getNextAttribute()
    {
        return ReleveIndexEau::where('indexdebut',$this->indexfin)->where('numcpteur',$this->numcpteur)->first();
    }

    public function compteur()
    {
        return $this->hasOne(CompteurEau::class, 'numcpteur', 'numcpteur');
    }

}
