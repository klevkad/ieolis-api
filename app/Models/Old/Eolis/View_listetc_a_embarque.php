<?php

namespace App\Models\Old\Eolis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View_listetc_a_embarque extends Model
{
    use HasFactory;

    protected $table = 'view_listetc_a_embarque';
    // protected $primaryKey = 'idprev_embarq';
    // public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'eolis';
    
    protected $fillable = [];

    public function produit()
    {
        return $this->hasMany(Booking_produit::class, 'reference', 'reference');
    }
    public function portdebarq()
    {
        return $this->hasOne(Port::class, 'codeport', 'port_deb');
    }
}
