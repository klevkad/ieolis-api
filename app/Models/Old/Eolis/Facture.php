<?php

namespace App\Models\Old\Eolis;

use App\Models\Archives\Document;
use App\Models\Archives\Dossarchive;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;

    protected $table = 'facture';
    protected $primaryKey = 'idfac';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'eolis';

    protected $appends = [
        'dossarchive',
    ];

    protected $with = [
        'tier',
        'documents'
    ];

    protected $fillable = [
    ];

    public function tier()
    {
        return $this->belongsTo(Compte_Tiers::class,'no_cpte_tiers','code_fourn');
    }

    public function documents()
    {
        return $this->hasMany(Document::class,'nodocument','idfac');
    }

    public function getDossarchiveAttribute()
    {
        return Dossarchive::where('nodossier','FOUR'.$this->idfac)->first();
    }

    public function getDocuments2Attribute()
    {
        return Document::where('nodossier','FOUR'.$this->idfac)
                        ->where('nodocument',$this->idfac);
    }

}
