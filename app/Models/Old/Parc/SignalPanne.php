<?php

namespace App\Models\Old\Parc;

use App\Models\Fichiers\RLieu;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignalPanne extends Model
{
    use HasFactory;

    protected $table = 'signal_panne';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    protected $connection = 'parc';
//    protected $keyType = 'string';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'categorie_panne_id' => 'integer',
    ];

    protected $fillable = [
        'id_ord_interv',
        'categorie_panne_id',
        'idengin',
        'idlieu',
        'description',
        'etat',
    ];

    protected $with = [
        'engin',
    ];

    protected $appends = [
        'attribution',
        'reception',
        'creator'
    ];

    public function getCreatorAttribute()
    {
        return User::find($this->created_by);
    }

    public function engin()
    {
        return $this->hasOne(Engin::class,'idengin','idengin');
    }

    public function lieu()
    {
        return $this->hasOne(RLieu::class,'idlieu','idlieu');
    }

    public function attribution_batterie()
    {
        return $this->belongsToMany(Batterie::class,'batterie_engin','signal_panne_id','batterie_id')
                    ->withPivot('debut','fin','observation');
    }

    public function reception_batterie()
    {
        return $this->belongsToMany(Batterie::class,'batterie_reception','signal_panne_id','batterie_id')
                    ->withPivot('date_reception','mod_docker_matricule','observation');
    }

    public function getAttributionAttribute()
    {
        return $this->attribution_batterie()->first();
    }

    public function getReceptionAttribute()
    {
        return $this->reception_batterie()->first();
    }

}
