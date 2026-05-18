<?php

namespace App\Models\Old\Parc;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batterie_Chargeur extends Model
{
    use HasFactory;

    protected $table = 'batterie_chargeur';
    protected $primaryKey = 'signal_panne_id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'chargeur_id',
        'batterie_id',
        'debut',
        'fin',
        'observation',
        'signal_panne_id',
        'created_by'
    ];

    protected $with = [/*'batterie', 'chargeur', 'signalpanne'*/];

    protected $appends = ['tpscharge'];

    public function getTpschargeAttribute()
    {
        return CarbonInterval::seconds(
            Carbon::createFromFormat('Y-m-d H:i:s', $this->fin ? $this->fin : now())->timestamp - Carbon::createFromFormat('Y-m-d H:i:s', $this->debut)->timestamp
        )->cascade()->format('%dj %hh %im %ss');
    }

    public function batterie()
    {
        return $this->belongsTo(Batterie::class, 'id', 'batterie_id');
    }

    public function signalpanne()
    {
        return $this->belongsTo(SignalPanne::class, 'id', 'signal_panne_id');
    }

    public function chargeur()
    {
        return $this->belongsTo(Chargeur::class, 'id', 'chargeur_id');
    }

    public function reception()
    {
        return $this->hasOne(Batterie_Reception1::class, 'signal_panne_id', 'signal_panne_id');
    }
}
