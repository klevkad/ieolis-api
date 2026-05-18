<?php

namespace App\Models\Old\Eolis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operateu extends Model
{
    use HasFactory;

	protected $connection = 'eolis';
    protected $table = 'operateu';
    protected $primaryKey = 'codeoper';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [];

    public function demandebookings()
    {
        return $this->hasMany('App\Models\Export\DemandeBooking');
    }
}
