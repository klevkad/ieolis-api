<?php

namespace App\Models\Old\Eolis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $table = 'produit';
    protected $primaryKey = 'produit';
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'eolis';
    protected $keyType = 'string';

    protected $fillable = [];
}
