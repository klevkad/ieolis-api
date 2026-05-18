<?php

namespace App\Models\Export;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sortie_AttributionFinRetour extends Model
{
    use HasFactory;

    protected $table = 'sortie';
    protected $primaryKey = 'idbon';
    public $incrementing = false;
    public $timestamps = false;
}
