<?php

namespace App\Models\Old\Acconage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatutTc extends Model
{
    use HasFactory;

    protected $table = 't_statu_tc';
    protected $primaryKey = 'idt_statu_tc';
//    protected $keyType = 'string';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'acconage';

}
