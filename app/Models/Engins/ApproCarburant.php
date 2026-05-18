<?php

namespace App\Models\Engins;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApproCarburant extends Model
{
    use HasFactory;

    protected $table = 'appro_carburants';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'booking';

    protected $fillable = [
        'idengin',
        'bon_appro',
        'qte_appro',
        'date_appro',
        'idlieu_appro'
    ];

    public function engin()
    {
        return $this->belongsTo('App\Models\Old\Parc\Engin', 'idengin', 'idengin');
    }

    public function lieuappro()
    {
        return $this->belongsTo('App\Models\Fichiers\LieuAppro','idlieu_appro','idlieu_appro');
    }

    public function model()
    {
        return $this->morphTo();
    }
}
