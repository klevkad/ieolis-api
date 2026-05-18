<?php

namespace App\Models\Export;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    protected $table = 'incidents';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'booking';

    protected $fillable = [
        'nobooking',
        'no_tc',
        'type_incident_id',
        'codetype',
        'commentaire',
        'act',
        'old_data',
    ];

    public function typeincident()
    {
        return $this->belongsTo('App\Models\Fichiers\TypeIncident','type_incident_id','id');
    }

    public function typengin()
    {
        return $this->belongsTo('App\Models\Old\Parc\Typengin','codetype','codetype');
    }

    public function model()
    {
        return $this->morphTo();
    }
}
