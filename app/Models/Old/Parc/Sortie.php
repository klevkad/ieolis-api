<?php

namespace App\Models\Old\Parc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sortie extends Model
{
    use HasFactory;
    
    protected $table = 'sortie';
    protected $primaryKey = 'idbon';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'parc';
    protected $keyType = 'string';

    protected $fillable = ['commentaire','datebon','numbon_phys','idbon','codeuser','top_abjspy','top_direct_stock','type_imp','full_url_signature','min_url_signature','ouverture_id','chauffeur','sicampagnemangue'];

     protected $casts = [
        'datebon' => 'datetime',
        'sicampagnemangue' => 'boolean', 
    ];

    public function lignesorties()
    {
        return $this->hasMany('App\Models\Old\Parc\LigneSortie', 'idbon', 'idbon');
    }
}
