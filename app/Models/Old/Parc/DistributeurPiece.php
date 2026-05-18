<?php
namespace App\Models\Old\Parc;

use Illuminate\Database\Eloquent\Model;

class DistributeurPiece extends Model
{
    protected $table = 'distributeur_pieces';
    public $timestamps = false;
    protected $connection = 'parc';
}
