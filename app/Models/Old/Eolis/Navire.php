<?php

namespace App\Models\Old\Eolis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Navire extends Model
{
    use HasFactory;

    protected $connection = 'eolis';
    protected $table = 'navire';
    protected $primaryKey = 'codenavire';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = ['codenavire','libnavire','typenavire'];

    public function escales()
    {
        return $this->hasMany('App\Models\Old\Eolis\Escale', 'codenavire', 'codenavire');
    }

}
