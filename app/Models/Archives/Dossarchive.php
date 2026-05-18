<?php

namespace App\Models\Archives;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dossarchive extends Model
{
    use HasFactory;

    protected $table = 'dossarchive';
    protected $primaryKey = 'nodossier';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;
    protected $connection = 'archive';
/*
*/
    const CREATED_AT = 'date_creation';
    const UPDATED_AT = 'date_modification';

    protected $casts = [
        'nodossier' => 'string'
    ];

    protected $fillable = [
    ];

    public function documents()
    {
        return $this->hasMany(Document::class,'nodossier','nodossier');
    }

}
