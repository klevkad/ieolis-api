<?php

namespace App\Models\Old\Parc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class Prise extends Model
{
    use HasFactory;

    protected $connection = 'parc';

    protected $fillable = [
        'libelle',
        'enabled'
    ];

    public function getQrcodefolderAttribute()
    {
        return '/img/qrcode/PRISES';
    }

    public function getQrcodeMinifolderAttribute()
    {
        return '/img/qrcode/PRISES/mini';
    }

    public function getQrcodeAttribute()
    {
        return 'img/qrcode/PRISES/'.$this->libelle.'.png';
    }

    public function getQrcodelinkAttribute()
    {
        return File::exists(Storage::disk('public')->path($this->qrcode)) ? 'http://api.eolis.ci/storage/img/qrcode/PRISES/'.$this->libelle.'.png?'.time() : '';
    }

}
