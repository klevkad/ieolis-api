<?php

namespace App\Models\Old\Parc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatterieWorkingTime extends Model
{
    use HasFactory;

    protected $table = 'batterie_working_time';
    protected $primaryKey = 'signal_panne_id';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'parc';

    protected $fillable = [
        'signal_panne_id',
        'debut',
        'fin',
        'created_by',
        'updated_by'
    ];

    protected $with = ['batteriecharge', 'attribution', /*'signalpanne', 'batterie', 'engin'*/];

    public function batteriecharge()
    {
        return $this->hasOne(Batterie_Chargeur::class, 'signal_panne_id', 'signal_panne_id')->whereNotNull('fin');
    }

    public function batterieengin()
    {
        return $this->belongsTo(Batterie_Engin::class, 'signal_panne_id', 'signal_panne_id');
    }

    public function batterieworkingtimes()
    {
        return $this->hasMany(BatterieWorkingTime::class, 'signal_panne_id', 'signal_panne_id');
    }

    public function signalpanne()
    {
        return $this->belongsTo(SignalPanne::class, 'signal_panne_id', 'id');
    }

    public function attribution()
    {
        return $this->hasOne(Batterie_Engin::class, 'signal_panne_id', 'signal_panne_id');
    }

}
