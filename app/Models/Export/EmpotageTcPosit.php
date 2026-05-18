<?php

namespace App\Models\Export;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpotageTcPosit extends Model
{
    use HasFactory;

    protected $table = 'empotage_tc_posit';
    protected $primaryKey = 'idempotage_tc';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'booking';

    protected $fillable = [
        'datehdeb_empot',
        'datehfin_empot',
        'si_depassement_facture',
        'observation',
        'idpositionnement',
        'codestation_empotage'
    ];

    public function positionnement()
    {
        return $this->belongsTo('App\Models\Export\PositionnementTC','idpositionnement','idpositionnement');
    }

    public function finposit()
    {
        return $this->hasOne('App\Models\Export\FinPositTC','idpositionnement','idpositionnement');
    }

    public function stationempotage()
    {
        return $this->belongsTo('App\Models\Fichiers\StationEmpotage','codestation_empotage','codestation_empotage');
    }

    public function retourtc()
    {
        return $this->hasOne('App\Models\Export\RetourTC','idpositionnement','idpositionnement');
    }
}
