<?php

namespace App\Models\Old\Parc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class Chargeur extends Model
{
    use HasFactory;

    protected $connection = 'parc';

    protected $fillable = [
        'libelle',
        'enabled'
    ];

    public function getQrcodefolderAttribute()
    {
        return '/img/qrcode/CHARGEURS';
    }

    public function getQrcodeMinifolderAttribute()
    {
        return '/img/qrcode/CHARGEURS/mini';
    }

    public function getQrcodeAttribute()
    {
        return 'img/qrcode/CHARGEURS/'.$this->libelle.'.png';
    }

    public function getQrcodeMiniAttribute()
    {
        return 'img/qrcode/CHARGEURS/mini/'.$this->libelle.'.png';
    }

    public function getQrcodelinkAttribute()
    {
        return File::exists(Storage::disk('public')->path($this->qrcode)) ? 'http://api.eolis.ci/storage/img/qrcode/CHARGEURS/'.$this->libelle.'.png?'.time() : '';
    }

}
