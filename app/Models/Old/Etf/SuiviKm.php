<?php

namespace App\Models\Old\Etf;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuiviKm extends Model
{
    use HasFactory;

    protected $table = 'suivi_index_engin';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    protected $connection = 'etf';

    protected $fillable = [
        'idengin',
        'curdate',
        'prev_date_id',
        'cptkm',
        'nbrtcv',
        'nbrtcp',
        'qtecarb',
        'nbrhrtrav',
    ];
}
