<?php

namespace App\Models\Fichiers;

use App\Models\Old\Parc\Typengin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panne extends Model
{
    use HasFactory;

    protected $table = 'pannes';
    protected $primaryKey = 'idpanne';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'booking';

    protected $fillable = [
        'lib_panne',
    ];

    public function typengins()
    {
        return $this->belongsToMany(Typengin::class, 'pannes_typengin', 'idpanne', 'codetype');
    }
}
