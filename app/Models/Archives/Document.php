<?php

namespace App\Models\Archives;

use App\Models\Old\Eolis\Facentet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory;

    protected $table = 'documents';
    protected $primaryKey = 'nodocument';
    public $incrementing = false;
    public $timestamps = true;
    protected $connection = 'archive';
/*
*/
    const CREATED_AT = 'date_enregistre';
    const UPDATED_AT = 'modifie_date';

    protected $fillable = [
        'pages'
    ];

    protected $casts = [
        'nodossier' => 'string'
    ];

//    protected $appends = ['npages'];

    public function dossierarchive()
    {
        return $this->belongsTo(Dossarchive::class,'nodossier','nodossier');
    }

    public function facentet()
    {
        return $this->belongsTo(Facentet::class,'no_fact','nodossier');
    }

    public function getNpagesAttribute() {
        $num = 0;
        try{
            $chemins = mb_split('\.', mb_substr($this->chemin_enregistre, 15));
            $pdftext = Storage::disk('ftp')->get(mb_strtoupper($chemins[0]).".".$chemins[1]);
            $num = preg_match_all("/\/Page\W/", $pdftext, $dummy);
        }catch(\Illuminate\Contracts\Filesystem\FileNotFoundException $ex){
            $num = -1;
        }
        return $num;
    }

}
