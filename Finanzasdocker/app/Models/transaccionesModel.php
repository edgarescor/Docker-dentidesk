<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaccionesModel extends Model
{
    use HasFactory;
    protected $table = "transacciones";
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $timestamps = false;
}
