<?php

namespace App\Models\Old\Eolis;

use App\Models\Archives\Document;
use App\Models\Archives\Dossarchive;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class View_Facentet extends Model
{
    use HasFactory;

    protected $table = 'view_facentet';
    protected $primaryKey = 'no_fact';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'eolis';

    protected $fillable = [];
    protected $appends = ['documents3','consultation','pages'];

    public function bltransit()
    {
        return $this->hasOneThrough(Bls::class,View_Dossfill::class,'no_dossier','idbl','idbl','idbl');
    }

    public function bl()
    {
        return $this->belongsTo(Bls::class,'idbl','idbl');
    }

    public function client()
    {
        return $this->belongsTo(Client::class,'code_cli','code_cli');
    }

    public function produitobj()
    {
        return $this->hasOne(Produit::class,'produit','produit');
    }

    public function operateur()
    {
        return $this->belongsTo(Operateu::class,'codeoper','codeoper');
    }

    public function dossarchive()
    {
        return $this->hasOne(Dossarchive::class,'nodossier','no_fact');
    }

    public function documents()
    {
        return $this->hasMany(Document::class,'nodossier','no_fact');
    }

    public function documents2()
    {
        return $this->hasMany(Document::class,'nodossier','idbl');
    }

    public function getDocuments3Attribute()
    {
        return $this->bl ? $this->bl->documents : ( $this->bltransit ? $this->bltransit->documents()->where('nodossier',$this->bltransit->noescale)->get() : collect() );
    }

    public function getPagesAttribute()
    {
        return $this->documents->sum('pages') +  $this->documents2->sum('pages') + $this->documents3->sum('pages');
    }

    public function consultations()
    {
        return $this->belongsToMany(View_User::class,'facentet_users','no_fact','user_id','no_fact','id');
    }

    public function getConsultationAttribute()
    {
        return $this->consultations()->where('user_id',Auth::user()->id)->get()->first();
    }

/*
    public function documents3()
    {
        return $this->hasManyThrough(
            View_Document::class,
            Bls::class,
            'idbl',
            'nodossier',
            'idbl',
            'dossier'
        );
    }
*/
}
