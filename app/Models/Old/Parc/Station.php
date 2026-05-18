<?php

namespace App\Models\Old\Parc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;
    protected $table = 'station_approvisionnement';
    protected $primaryKey = 'stationid';
    public $incrementing = true;
    protected $keyType = 'string';
    protected $connection = 'parc';

    protected $fillable = [
        'stationid',
        'libellestation',
    ];

    public function distributeurs()
    {
        return $this->belongsToMany(
            Distributeur::class, 
            'station_distributeur', 
            'stationid', 
            'distributeurid'
        );
    }
}