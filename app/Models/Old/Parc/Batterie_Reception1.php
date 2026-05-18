<?php

namespace App\Models\Old\Parc;

use App\Models\Old\Acconage\Mod_Docker;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batterie_Reception1 extends Model
{
    use HasFactory;

    protected $table = 'batterie_reception';
    protected $primaryKey = 'signal_panne_id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'mod_docker_matricule',
        'batterie_id',
        'date_reception',
        'observation',
        'signal_panne_id',
        'created_by'
    ];

    protected $with = ['charge'];

    public function batterie()
    {
        return $this->belongsTo(Batterie::class);
    }

    public function signalpanne()
    {
        return $this->belongsTo(SignalPanne::class);
    }

    public function docker()
    {
        return $this->belongsTo(Mod_Docker::class, 'matricule', 'mod_docker_matricule');
    }

    public function charge()
    {
        return $this->hasOne(Batterie_Chargeur::class, 'signal_panne_id', 'signal_panne_id');
    }
}
