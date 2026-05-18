<?php

namespace App\Models\Old\Parc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distributeur extends Model
{
    use HasFactory;

    protected $table = 'distributeurs';
    protected $primaryKey = 'distributeurid';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $connection = 'parc';

    protected $fillable = [
        'distributeurid',
        'libelledistributeur',
    ];

    public function stations()
    {
        return $this->belongsToMany(Station::class, 'station_distributeur', 'distributeurid', 'stationid');
    }

    public function produits()
    {
        return $this->belongsToMany(Piece::class, 'distributeur_pieces', 'distributeurid', 'idpiece');
    }
}