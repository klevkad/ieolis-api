<?php

namespace App\Models\Old\Acconage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduitBranch extends Model
{
    use HasFactory;

    protected $table = 't_prod_branch';
    protected $primaryKey = 'grou_prod';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'acconage';

}
