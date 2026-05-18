<?php

namespace App\Models\Old\Eolis;

use App\Models\Archives\Document;
use App\Models\Archives\Dossarchive;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facentet extends Model
{
    use HasFactory;

    protected $table = 'facentet';
    protected $primaryKey = 'no_fact';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'eolis';

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
