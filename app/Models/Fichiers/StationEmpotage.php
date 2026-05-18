<?php

namespace App\Models\Fichiers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StationEmpotage extends Model
{
    use HasFactory;

    protected $table = 'station_empotage';
    protected $primaryKey = 'codestation_empotage';
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'booking';
    protected $keyType = 'string';

    protected $fillable = [
        'codestation_empotage',
        'lib_station',
        'idlieu'
    ];

    public function empotages()
    {
        return $this->hasMany('App\Models\Export\EmpotageTcPosit','codestation_empotage','codestation_empotage');
    }

    public function lieu()
    {
        return $this->belongsTo('App\Models\Old\Eolis\Port','idlieu','codeport');
    }
}
