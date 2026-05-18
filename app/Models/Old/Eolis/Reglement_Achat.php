<?php

namespace App\Models\Old\Eolis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reglement_Achat extends Model
{
    use HasFactory;

    protected $table = 'reglement_achat';
    protected $primaryKey = 'idreg_achat';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'eolis';

    protected $appends = [
        'tier'
    ];

    protected $with = [
        'factures'
    ];

    protected $fillable = [
    ];

    public function getTierAttribute()
    {
        return $this->tiers()->first();
    }

    public function tiers()
    {
        return $this->belongsToMany(
            Compte_Tiers::class, 
            'reglement_achat_compte_tiers', 
            'idreg_achat', 
            'no_cpte_tiers', 
            'idreg_achat', 
            'no_cpte_tiers'
        );
    }

    public function factures()
    {
        return $this->belongsToMany(
            Facture::class, 
            'reglement_achat_facture', 
            'idreg_achat', 
            'idfac', 
            'idreg_achat', 
            'idfac'
        );
    }

}
