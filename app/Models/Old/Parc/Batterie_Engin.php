<?php

namespace App\Models\Old\Parc;

use App\Models\Fichiers\RLieu;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batterie_Engin extends Model
{
    use HasFactory;

    protected $table = 'batterie_engin';
    protected $primaryKey = 'signal_panne_id';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'parc';

    protected $fillable = [
        'idengin',
        'batterie_id',
        'idlieu',
        'debut',
        'fin',
        'observation',
        'signal_panne_id',
        'created_by'
    ];

    protected $with = [/*'batterie', 'engin'*/];

    public function lieu()
    {
        return $this->belongsTo(RLieu::class, 'idlieu', 'idlieu');
    }

    public function batterie()
    {
        return $this->belongsTo(Batterie::class, 'batterie_id', 'id');
    }

    public function signalpanne()
    {
        return $this->belongsTo(SignalPanne::class, 'signal_panne_id', 'id');
    }

    public function engin()
    {
        return $this->belongsTo(Engin::class, 'idengin', 'idengin');
    }

    public function batterieworkingtimes()
    {
        return $this->hasMany(BatterieWorkingTime::class, 'signal_panne_id', 'signal_panne_id');
    }
}
