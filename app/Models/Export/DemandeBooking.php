<?php

namespace App\Models\Export;

use App\Models\Old\Eolis\Operateu;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DemandeBooking extends Model
{
    use HasFactory;

    protected $table = 'p_demande_booking';
    protected $primaryKey = 'iddemande_booking';
    public $incrementing = true;
    public $timestamps = true;
    protected $connection = 'booking';
/*
*/
    const CREATED_AT = 'saisie_le';
    const UPDATED_AT = 'modif_le';
    protected $dates = ['deleted_at'];

    protected $fillable = [ 
        'no_booking',
        'idutilisateur_client',
        'si_valider',
        'ct_num',
        'payeurfret',
        'si_transporteur_eolis',
        'date_demande',
        'produit',
        'idlieu_arrive',
        'noescale',
        'idtransporteur',
        'type_demande'
    ];
    protected $appends = [
        'qrcodelink', 
    ];


    public function getQrcodefolderAttribute()
    {
        return '/img/qrcode/Bookings/'.mb_substr($this->date_demande,0,4);
    }

    public function getQrcodeMinifolderAttribute()
    {
        return '/img/qrcode/Bookings/'.mb_substr($this->date_demande,0,4).'/mini';
    }

    public function getQrcodeAttribute()
    {
        return 'img/qrcode/Bookings/'.mb_substr($this->date_demande,0,4).'/'.$this->no_booking.'.png';
    }

    public function getQrcodeMiniAttribute()
    {
        return 'img/qrcode/Bookings/'.mb_substr($this->date_demande,0,4).'/mini//'.$this->no_booking.'.png';
    }

    public function getQrcodelinkAttribute()
    {
        return File::exists(Storage::disk('public')->path($this->qrcode)) ? 'https://api.eolis.ci/storage/img/qrcode/Bookings/'.mb_substr($this->date_demande,0,4).'/'.$this->no_booking.'.png?'.time() : '';
    }


    public function attributiontc()
    {
        return $this->hasManyThrough(
            'App\Models\Export\AttributionTc',
            'App\Models\Export\BookingTC', 
            'iddemande_booking', 
            'idbooking_conteneur',
            'iddemande_booking',
            'idbooking_conteneur'
        );
    }

    public function bookingtc()
    {
        return $this->hasOne('App\Models\Export\BookingTC', 'iddemande_booking', 'iddemande_booking');
    }

    public function bookingtcfinal()
    {
        return $this->hasOne('App\Models\Export\BookingTcFinal', 'iddemande_booking', 'iddemande_booking');
    }

    public function motifrefus()
    {
        return $this->hasOne('App\Models\Export\MotifRefusBooking', 'iddemande_booking', 'iddemande_booking');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\Users', 'idutilisateur_client', 'id');
    }

    public function client()
    {
        return $this->belongsTo(Operateu::class, 'ct_num', 'codeoper', 'eolis.operateu');
    }

    public function transporteur()
    {
        return $this->belongsTo('App\Models\Fichiers\Transporteur', 'idtransporteur', 'idtransporteur');
    }

    public function escale()
    {
        return $this->belongsTo('App\Models\Old\Eolis\Escale', 'noescale', 'noescale');
    }

    public function destination()
    {
        return $this->belongsTo('App\Models\Old\Eolis\Port', 'idlieu_arrive', 'codeport');
    }
/*
    public function operateur()
    {
        return $this->belongsTo('App\Models\Old\Eolis\Operateu', 'ct_num', 'codeoper');
    }
*/
    public function clientNew()
    {
        return $this->belongsTo('App\Models\Compta\F_Comptet', 'ct_num', 'CT_Num');
    }

    public function payeurfret()
    {
        return $this->belongsTo('App\Models\Compta\F_Comptet', 'payeurfret', 'CT_Num');
    }

    public function produitdmd()
    {
        return $this->belongsTo('App\Models\Old\Eolis\Produit', 'produit', 'produit');
    }
}
