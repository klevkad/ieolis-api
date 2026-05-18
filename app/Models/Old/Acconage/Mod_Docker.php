<?php

namespace App\Models\Old\Acconage;

use App\Models\Old\Parc\Batterie;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mod_Docker extends Model
{
    use HasFactory;

    protected $table = 'mod_dockers';
    protected $primaryKey = 'matricule';
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'acconage';

    protected $fillable = [];

    public function batteries()
    {
        return $this->belongsToMany(
            Batterie::class, 
            'batterie_reception', 
            'mod_docker_matricule', 
            'batterie_id', 
            'matricule', 
            'id'
        )->orderBy('date_reception','desc');
    }

}
