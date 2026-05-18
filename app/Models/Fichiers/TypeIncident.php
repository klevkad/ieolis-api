<?php

namespace App\Models\Fichiers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeIncident extends Model
{
    use HasFactory;

    protected $table = 'type_incidents';/*
    protected $primaryKey = 'id';
    public $incrementing = true;*/
    public $timestamps = false;
    protected $connection = 'booking';

    protected $fillable = [
        'libelle',
    ];
}
