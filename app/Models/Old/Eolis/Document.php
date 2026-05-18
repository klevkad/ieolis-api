<?php

// namespace App\Models\Archives;
namespace App\Models\Old\Eolis;

use App\Models\Old\Eolis\Facentet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $table = 'documents';
    protected $primaryKey = 'nodocument';
    public $incrementing = false;
    public $timestamps = true;
    protected $connection = 'eolis';
/*
*/
    const CREATED_AT = 'date_enregistre';
    const UPDATED_AT = 'modifie_date';

    protected $fillable = [
    ];

    protected $casts = [
        'nodossier' => 'string'
    ];

    public function dossierarchive()
    {
        return $this->belongsTo(Dossarchive::class,'nodossier','nodossier');
    }

    public function facentet()
    {
        return $this->belongsTo(Facentet::class,'no_fact','nodossier');
    }

}
