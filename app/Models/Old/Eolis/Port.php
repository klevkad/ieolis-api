<?php

namespace App\Models\Old\Eolis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Port extends Model
{
    use HasFactory;

    protected $table = 'port';
    protected $primaryKey = 'codeport';
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'eolis';
    protected $keyType = 'string';
    
    protected $fillable = [];

    public function stationempotages()
    {
        return $this->hasMany('App\Models\Booking\StationEmpotage','idlieu','codeport');
    }

    public function lieuappros()
    {
        return $this->hasMany('App\Models\Booking\LieuAppro','idlieu','codeport');
    }
}
