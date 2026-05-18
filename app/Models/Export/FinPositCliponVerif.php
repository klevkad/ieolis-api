<?php

namespace App\Models\Export;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinPositCliponVerif extends Model
{
    use HasFactory;

    protected $table = 'fin_posit_clipon_verif';
    protected $primaryKey = 'idpositionnement';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'booking';

    protected $fillable = [
        'cadenas1',
        'cadenas2',
        'cadenas3',
        'flexible1',
        'flexible2'
    ];

    public function attributionclipon()
    {
        return $this->hasOneThrough(
            'App\Models\Export\AttributionClipon',
            'App\Models\Export\PositionnementTc',
            'idpositionnement',
            'idattribution_tc',
            'idpositionnement',
            'idpositionnement'            
        );
    }

    public function attributioncliponverif()
    {
        return $this->hasOneThrough(
            'App\Models\Export\AttributionCliponVerif',
            'App\Models\Export\PositionnementTc',
            'idpositionnement',
            'idattribution_tc',
            'idpositionnement',
            'idpositionnement'            
        );
    }

    public function finposit()
    {
        return $this->belongsTo('App\Models\Export\FinPositTc','idpositionnement','idpositionnement');
    }

    public function positionnement()
    {
        return $this->hasOne('App\Models\Export\PositionnementTC','idpositionnement','idpositionnement');
    }
}
