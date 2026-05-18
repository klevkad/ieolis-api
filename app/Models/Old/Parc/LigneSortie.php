<?php

namespace App\Models\Old\Parc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LigneSortie extends Model
{
    use HasFactory;

    protected $table = 'lignesor';
    protected $primaryKey = 'idlignesor'; 
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'parc';
    protected $keyType = 'string';
    
    protected $fillable = ['idlignesor','idengin', 'qtesortie', 'idbon', 'datesaisie', 'idpiece', 'codeservice', 'enregistre'];

    public function sortie()
    {
        return $this->belongsTo('App\Models\Old\Parc\Sortie', 'idbon', 'idbon');
    }

    public function piece()
    {
        return $this->belongsTo('App\Models\Old\Parc\Piece', 'idpiece', 'idpiece');
    }
}
