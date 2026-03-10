<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;
    protected $table = 'factura';
    protected $fillable = ['reserva_id', 'fecha', 'precio_total'];
    public $timestamps = true;
}
