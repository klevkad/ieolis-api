<?php

namespace App\Models\Old\Acconage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReleveTemperatureReefer extends Model
{
    use HasFactory;

    protected $table = 'releve_temp_journalier';
    protected $primaryKey = 'idreleve_temp';
//    protected $keyType = 'string';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'acconage';
/*
    const CREATED_AT = 'saisie_le';
    const UPDATED_AT = '';
*/
    protected $fillable = [
        'fav_setting',
        'return_air',
        'supply_air',
        'date_releve',
        'saisie_le',
        'codeuser',
        'idt_opera8branch',
        'lib_shift',
        'co2',
        'o2',
    ];

    protected $with = ['branchement', 'releveshift'];

    public function branchement()
    {
        return $this->belongsTo(Branchement::class, 'idt_opera8branch', 'idt_opera8branch');
    }

    public function releveshift()
    {
        return $this->hasOne(ReleveShift::class, 'lib_shift', 'lib_shift');
    }

}
