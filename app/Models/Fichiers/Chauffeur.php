<?php

namespace App\Models\Fichiers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chauffeur extends Model
{
    use HasFactory;

    protected $table = 'chauffeur';
    protected $primaryKey = 'idchauffeur';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'booking';

    protected $fillable = [
        'idtransporteur',
        'nom_chauffeur',
        'prenom_chauffeur',
        'no_pc',
        'tel_mob'
    ];

    public function getLibelleAttribute()
    {
        return $this->nom_chauffeur.' '.$this->prenom_chauffeur;
    }

    public function transporteur()
    {
        return $this->belongsTo('App\Models\Fichiers\Transporteur','idtransporteur','idtransporteur');
    }
}
