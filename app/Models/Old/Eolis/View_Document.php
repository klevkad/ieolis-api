<?php

namespace App\Models\Old\Eolis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View_Document extends Model
{
    use HasFactory;

    protected $table = 'view_documents';
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

}
