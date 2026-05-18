<?php

namespace App\Models\Old\Eolis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class A_Mvtcs extends Model
{
    use HasFactory;

    protected $table = 'a_mvtcs';
    protected $primaryKey = 'id_mvtcs';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'eolis';
    
    protected $fillable = [];

    public function operateur()
    {
        return $this->belongsTo(Operateu::class,'codeoper','codeoper');
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class,'produit','produit');
    }

}
