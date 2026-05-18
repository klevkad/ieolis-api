<?php

namespace App\Models\Old\Etf;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class Engin extends Model
{
    use HasFactory;

    protected $table = 'engin';
    protected $primaryKey = 'idengin';
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'parc';
    protected $keyType = 'string';
    
    protected $fillable = [];
    protected $appends = ['qrcodelink', 'assurance', 'oi', 'visitetechnique'];

    public function getQrcodefolderAttribute()
    {
        return '/img/qrcode/'.$this->codetype;
    }

    public function getQrcodeAttribute()
    {
        return 'img/qrcode/'.$this->codetype.'/'.$this->idengin.'.png';
    }

    public function getQrcodelinkAttribute()
    {
        return File::exists(Storage::disk('public')->path($this->qrcode)) ? 'http://api.eolis.ci/storage/img/qrcode/'.$this->codetype.'/'.$this->idengin.'.png?'.time() : '';
    }

    public function getAssuranceAttribute()
    {
        return $this->assurances->first();
    }

    public function assurances()
    {
        return $this->hasMany(Assurance::class,'idengin','idengin')->orderBy('datefinassur','desc')->limit(10);
    }

    public function sortiecarburants()
    {
        return $this->hasMany(LigneSortie::class,'idengin','idengin')->orderBy('idlignesor','desc')->whereIn('idpiece',[896908, 896952, 896988, 897003, 897037, 1287612])->limit(10);
    }

    public function getOiAttribute()
    {
        return $this->ois->first();
    }

    public function ois()
    {
        return $this->hasMany(OI::class,'idengin','idengin')->orderBy('dateheure_declaration','desc')->limit(10);
    }

    public function typengin()
    {
        return $this->hasOne(Typengin::class,'codetype','codetype');
    }

    public function getVisitetechniqueAttribute()
    {
        return $this->visitetechniques->first();
    }

    public function visitetechniques()
    {
        return $this->hasMany(VisiteTechnique::class,'idengin','idengin')->orderBy('datefinvisite','desc')->limit(10);
    }

}
