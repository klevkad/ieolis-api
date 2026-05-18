<?php

namespace App\Models\Old\Acconage;

use App\Models\Old\Eolis\Facentet;
use App\Models\Old\Eolis\Operateu;
use App\Models\Old\Eolis\Port;
use App\Models\Old\Eolis\Produit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branchement extends Model
{
    use HasFactory;

    protected $table = 't_opera_branch';
    protected $primaryKey = 'idt_opera8branch';
//    protected $keyType = 'string';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'acconage';

    protected $appends = [];
    protected $fillable = [
//        'idt_opera8branch',
        'semainedebut',
        'semainefin',
        'noescale',
        'codearma',
        'codenavire',
        'no_tc',
        'numcompteur',
        'trafic',
        'codeoper',
        'produit',
        'temp',
        'idt_statu_tc',
        'codeport',
        'site',
        'heurdebutbranch',
        'heurfinbranch',
        'heurfinbranchfactu',
        'nbreheure_reel',
        'nbreheure_factu',
        'numerodumois',
        'libmois',
        'datesaisie',
        'codeuser',
        'no_fact',
        'date_branch_fact',
        'num_bad',
        'etat',
    ];

    protected $with = ['compteur','facture','port','operateur','produit','produit2','statuttc','traffic'];

/*
    public function getNextAttribute()
    {
        return Branchement::where('indexdebut',$this->indexfin)->where('numcompteur',$this->numcompteur)->first();
    }
*/

    public function compteur()
    {
        return $this->hasOne(Compteur::class, 'numcompteur', 'numcompteur');
    }

    public function facture()
    {
        return $this->belongsTo(Facentet::class,'no_fact','no_fact');
    }

    public function operateur()
    {
        return $this->belongsTo(Operateu::class,'codeoper','codeoper');
    }

    public function port()
    {
        return $this->belongsTo(Port::class,'codeport','codeport');
    }

    public function produit()
    {
        return $this->belongsTo(ProduitBranch::class,'produit','grou_prod');
    }

    public function produit2()
    {
        return $this->belongsTo(Produit::class,'produit','produit');
    }

    public function relevetemperaturereefers()
    {
        return $this->hasMany(ReleveTemperatureReefer::class, 'idt_opera8branch', 'idt_opera8branch');
    }

    public function statuttc()
    {
        return $this->belongsTo(StatutTc::class,'idt_statu_tc','idt_statu_tc');
    }

    public function traffic()
    {
        return $this->belongsTo(Traffic::class,'trafic','idtraffic');
    }

}
