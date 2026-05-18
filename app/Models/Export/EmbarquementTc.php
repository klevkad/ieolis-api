<?php

namespace App\Models\Export;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmbarquementTc extends Model
{
    use HasFactory;

    protected $table = 'emb_conteneur';
    protected $primaryKey = 'idemb_conteneur';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'booking';

    protected $fillable = [
        'idretour_conteneur',
        'noescale',
        'dateh_emb'
    ];

    public function retourtc()
    {
        return $this->belongsTo('App\Models\Export\RetourTc','idretour_conteneur','idretour_conteneur');
    }

    public function retourtcpropremoyen()
    {
        return $this->belongsTo('App\Models\Export\RetourTcPropreMoyen','idretour_conteneur','idretour_tc');
    }

    public function finretourtc()
    {
        return $this->belongsTo('App\Models\Export\FinRetourTC','idretour_conteneur','idretour_conteneur');
    }

    public function escale()
    {
        return $this->belongsTo('App\Models\Old\Eolis\Escale','noescale','noescale');
    }
}
