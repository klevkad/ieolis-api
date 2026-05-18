<?php

namespace App\Models\Compta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class F_Comptet extends Model
{
    use HasFactory;

    protected $connection = 'compta';
    protected $table = 'f_comptet';
    protected $primaryKey = 'cbMarq';
    public $incrementing = true;
    public $timestamps = false;
    
    protected $fillable = [];

    public function toArray()
    {
        $array = parent::toArray();
        foreach($array as $key => $value) {
            $array[$key] = $this->convertUtf8($value);
        }
        return $array;
    }

    public function convertUtf8( $value ) {
        return mb_detect_encoding($value, mb_detect_order(), true) === 'UTF-8' ? $value : mb_convert_encoding($value, 'UTF-8');
    }

    public function demandebookings()
    {
        return $this->hasMany('App\Models\Export\DemandeBooking', 'ct_num', 'ct_num');
    }

    public function payerfretdemandebookings()
    {
        return $this->hasMany('App\Models\Export\DemandeBooking', 'payeurfret', 'ct_num');
    }
}
