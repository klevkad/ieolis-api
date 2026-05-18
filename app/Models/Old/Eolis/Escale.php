<?php

namespace App\Models\Old\Eolis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Escale extends Model
{
    use HasFactory;

    protected $connection = 'eolis';
    protected $table = 'escale';
    protected $primaryKey = 'noescale';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = ['noescale','codenavire','etad'];

    public function embtcs()
    {
        return $this->hasMany('App\Models\Export\EmbarquementTC', 'noescale', 'noescale');
    }

    public function navire()
    {
        return $this->belongsTo('App\Models\Old\Eolis\Navire', 'codenavire', 'codenavire');
    }

    public function emb()
    {
        return $this->hasMany('App\Models\Old\Eolis\A_Tcsemb', 'noescale', 'noescale');
    }

    public function deb()
    {
        return $this->hasMany('App\Models\Old\Eolis\A_Tcsdeb', 'noescale', 'noescale');
    }

    public function qty_emb()
    {
        return $this->emb()->selectRaw('noescale, count(*) as qty')->where('TOP_TBDT',2)->groupBy('noescale');
    }

    public function qty_deb()
    {
        return $this->deb()->selectRaw('noescale, count(*) as qty')->where('TOP_TBDT',2)->groupBy('noescale');
    }
}
