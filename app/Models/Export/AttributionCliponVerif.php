<?php

namespace App\Models\Export;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributionCliponVerif extends Model
{
    use HasFactory;

    protected $table = 'attribution_clipon_verif';
    protected $primaryKey = 'idattribution_tc';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'booking';

    protected $fillable = [
        'idattribution_tc',
        'cadenas1',
        'cadenas2',
        'cadenas3',
        'flexible1',
        'flexible2'
    ];

/*
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
        return $this->hasOneThrough(
            'App\History',
            'App\User',
            'supplier_id', // Foreign key on users table...
            'user_id', // Foreign key on history table...
            'id', // Local key on suppliers table...
            'id' // Local key on users table...
        );
 */
    public function attributionclipon()
    {
        return $this->belongsTo( 'App\Models\Export\AttributionClipon', 'idattribution_tc', 'idattribution_tc' );
    }

    public function finpositcliponverif()
    {
        return $this->hasOneThrough(
            'App\Models\Export\FinPositCliponVerif',
            'App\Models\Export\PositionnementTc',
            'idattribution_tc',
            'idpositionnement',
            'idattribution_tc',
            'idattribution_tc'            
        );
    }

    public function finposit()
    {
        return $this->hasOneThrough(
            'App\Models\Export\FinPositTc',
            'App\Models\Export\PositionnementTc',
            'idattribution_tc',
            'idpositionnement',
            'idattribution_tc',
            'idattribution_tc'            
        );
    }

    public function positionnement()
    {
        return $this->hasOne('App\Models\Export\PositionnementTc','idattribution_tc','idattribution_tc');
    }
}
