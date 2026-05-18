<?php

namespace App\Models\Old\Eco;

use App\Models\Archives\Document;
use App\Models\Archives\Dossarchive;
use App\Models\Old\Eolis\Bls;
use App\Models\Old\Eolis\Client;
use App\Models\Old\Eolis\Operateu;
use App\Models\Old\Eolis\Produit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fact_Entete extends Model
{
    use HasFactory;

    protected $table = 'fact_entete';
    protected $primaryKey = 'no_fact';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'eco';

/*
    const CREATED_AT = 'date_creation';
    const UPDATED_AT = 'date_modification';
*/

    protected $fillable = [
    ];

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

}
