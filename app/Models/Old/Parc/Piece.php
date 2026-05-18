<?php

namespace App\Models\Old\Parc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piece extends Model
{
    use HasFactory;

    protected $table = 'piece';
    protected $primaryKey = 'idpiece';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $connection = 'parc';

    protected $fillable = [
        'idpiece',
        'codepiece',
        'designation',
        'codefam'
    ];

    public function distributeurs()
    {
        return $this->belongsToMany(Distributeur::class, 'distributeur_pieces', 'idpiece', 'distributeurid');
    }
}