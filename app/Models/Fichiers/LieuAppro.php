<?php

namespace App\Models\Fichiers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LieuAppro extends Model
{
    use HasFactory;

    protected $table = 'lieu_appro';
    protected $primaryKey = 'idlieu_appro';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'booking';

    protected $fillable = [
        'libelle_lieu_appro',
        'idlieu'
    ];

    public function lieu()
    {
        return $this->belongsTo('App\Models\Old\Eolis\Port','idlieu','codeport');
    }
}
