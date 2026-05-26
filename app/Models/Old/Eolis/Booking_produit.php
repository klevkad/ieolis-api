<?php

namespace App\Models\Old\Eolis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking_produit extends Model
{
    use HasFactory;

    protected $table = 'booking_produit';
    protected $primaryKey = 'idbooking_produit';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'eolis';

    protected $fillable = [
        'idbooking_produit',
        'reference',
        'produit'
    ];

    public function produit()
    {
        return $this->hasOne(Produit::class, 'produit', 'produit');
    }
   
 }
