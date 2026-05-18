<?php

namespace App\Models\Fichiers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transporteur extends Model
{
    use HasFactory;

    protected $table = 'transporteur';
    protected $primaryKey = 'idtransporteur';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'booking';

    protected $fillable = [
        'lib_transporteur',
        'si_tier'
    ];

    public function chauffeurs()
    {
        return $this->hasMany('App\Models\Fichiers\Chauffeur','idtransporteur','idtransporteur')->orderBy('nom_chauffeur')->orderBy('prenom_chauffeur');
    }
}
