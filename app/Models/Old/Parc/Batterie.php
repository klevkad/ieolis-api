<?php

namespace App\Models\Old\Parc;

use App\Models\Old\Acconage\Mod_Docker;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class Batterie extends Model
{
    use HasFactory;

    protected $connection = 'parc';
    protected $fillable = [
        'libelle',
        'idpiece',
        'codetype',
        'enabled',
        'acquisition',
        'capacite',
        'tension',
        'batterietype_id',
        'batterieetat_id',
    ];
    protected $casts = [
        'batterietype_id' => 'integer',
        'batterieetat_id' => 'integer',
        'acquisition' => 'datetime:Y-m-d',
        'enabled' => 'boolean',
    ];
    protected $appends = [
        'qrcodelink', 
        'status',
        'attribution',
        'charge',
        'tpschargemoy',
        'workingtimemoy',
        'workingtimes',
        'reception'
    ];
    protected $with = [
        'batterieetat', 
        'batterietype', 
        'batterieworkingtimes', 
//        'charges', 
        'typengin', 
//        'batteriechargeurs', 
//        'engins', 
//        'receptions'
    ];

    public function getQrcodefolderAttribute()
    {
        return '/img/qrcode/B'.$this->codetype;
    }

    public function getQrcodeMinifolderAttribute()
    {
        return '/img/qrcode/B'.$this->codetype.'/mini';
    }

    public function getQrcodeAttribute()
    {
        return 'img/qrcode/B'.$this->codetype.'/'.$this->libelle.'.png';
    }

    public function getQrcodeMiniAttribute()
    {
        return 'img/qrcode/B'.$this->codetype.'/mini//'.$this->libelle.'.png';
    }

    public function getQrcodelinkAttribute()
    {
        return File::exists(Storage::disk('public')->path($this->qrcode)) ? 'http://api.eolis.ci/storage/img/qrcode/B'.$this->codetype.'/'.$this->libelle.'.png?'.time() : '';
    }

    public function getStatusAttribute()
    {
        $lBchargeur = $this->batteriechargeurs()->first();
        $lBengin = $this->batterieengins()->first();
//        $lBrecep = $this->batteriereceptions()->first();
        return ( ($lBchargeur && $lBchargeur->fin) ? ( ($lBengin && $lBengin->fin) ? 'Receptionnée' : ( $lBengin ? 'Attribuée à '.$lBengin->idengin : 'Chargée' ) ) : ( $lBchargeur ? 'En charge sur '.$this->charge->libelle : '' ) );
    }

    public function getAttributionAttribute()
    {
        return $this->engins()->first();
    }

    public function getReceptionAttribute()
    {
        return $this->receptions()->first();
    }

    public function getChargeAttribute()
    {
        return $this->charges()->first();
    }

    public function getWorkingtimesAttribute()
    {
        return $this->batterieworkingtimes->sortBy([['signal_panne_id', 'desc']])->groupBy('signal_panne_id')->map(function ($batterieworkingtimes, $key) {
            return [
                'signal_panne_id' => $key,
                'charge' => $batterieworkingtimes[0]->batteriecharge,
                'attribution' => $batterieworkingtimes[0]->attribution,/*
                'signalpanne' => $batterieworkingtimes[0]->signalpanne,*/
                'tpsactivite' => CarbonInterval::seconds($batterieworkingtimes->avg(function ($batterieworkingtime) {
                    return Carbon::createFromFormat('Y-m-d H:i:s', $batterieworkingtime->fin)->timestamp - Carbon::createFromFormat('Y-m-d H:i:s', $batterieworkingtime->debut)->timestamp;
                }))->cascade()->format('%dj %hh %im %ss')
            ];
        })->values();
    }

    public function getWorkingtimemoyAttribute()
    {
        return CarbonInterval::seconds($this->batterieworkingtimes->avg(function ($batterieworkingtime) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $batterieworkingtime->fin)->timestamp - Carbon::createFromFormat('Y-m-d H:i:s', $batterieworkingtime->debut)->timestamp;
        }))->cascade()->format('%dj %hh %im %ss');
    }

    public function getTpschargemoyAttribute()
    {
        return CarbonInterval::seconds($this->chargeAvecFin->avg(function ($chargeur) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $chargeur->pivot->fin)->timestamp - Carbon::createFromFormat('Y-m-d H:i:s', $chargeur->pivot->debut)->timestamp;
        }))->cascade()->format('%dj %hh %im %ss');
    }

    public function batterieetat()
    {
        return $this->belongsTo(BatterieEtat::class,'batterieetat_id','id');
    }

    public function batterietype()
    {
        return $this->belongsTo(BatterieType::class,'batterietype_id','id');
    }

    public function typengin()
    {
        return $this->belongsTo(Typengin::class,'codetype','codetype');
    }

    public function batterieworkingtimes()
    {
        return $this->hasManyThrough(
            BatterieWorkingTime::class,
            Batterie_Engin::class,
            'batterie_id',
            'signal_panne_id',
            'id',
            'signal_panne_id'
        );
    }

    public function engins()
    {
        return $this->belongsToMany(
            Engin::class,
            'batterie_engin',
            'batterie_id',
            'idengin',
            'id'
        )->withPivot('debut','fin','observation')->orderBy('debut','desc');
    }

    public function enginSansFin()
    {
        return $this->belongsToMany(
            Engin::class,
            'batterie_engin',
            'batterie_id',
            'idengin',
            'id'
        )->wherePivotNull('fin');
    }

/*
    public function getEnginsAttribute()
    {
        return $this->batterieengins()->engin;
    }
*/

    public function batterieengins()
    {
        return $this->hasMany( Batterie_Engin::class, 'batterie_id', 'id' )->orderBy('debut','desc');
    }

    public function batterieenginencours()
    {
        return $this->hasMany( Batterie_Engin::class, 'batterie_id', 'id' )->whereNull('fin')->orderBy('debut','desc');
    }

/*
    public function receptions()
    {
        return $this->belongsToMany(
            Mod_Docker::class, 
            'batterie_reception', 
            'batterie_id', 
            'mod_docker_matricule',
            'id',
            'matricule'
        )->orderBy('date_reception','desc')->limit(10);
    }
*/

    public function receptions()
    {
        return $this->hasMany(Batterie_Reception1::class)->orderBy('date_reception','desc');
    }

    public function receptions2()
    {
        return $this->belongsToMany(
            Batterie_Reception::class, 
            'batterie_reception', 
            'batterie_id', 
            'mod_docker_matricule',
            'id',
            'matricule'
        );
    }

    public function batteriechargeurs()
    {
        return $this->hasMany(Batterie_Chargeur::class, 'batterie_id', 'id')->orderBy('debut','desc');
    }

    public function charges()
    {
        return $this->belongsToMany(Chargeur::class)->withPivot('debut','fin')->orderBy('debut','desc')->limit(10);
    }

    public function chargeAvecFin()
    {
        return $this->belongsToMany(Chargeur::class)->withPivot('debut','fin')->wherePivotNotNull('fin');
    }

    public function chargeSansFin()
    {
        return $this->belongsToMany(Chargeur::class)->wherePivotNull('fin');
    }

    public function charges2()
    {
        return $this->belongsToMany(Chargeur::class)->withPivot('debut','fin')->orderBy('debut','desc');
    }

}
