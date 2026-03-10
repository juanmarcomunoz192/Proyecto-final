<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;
    protected $table = 'reserva';
    protected $fillable = ['hotel_id', 'habitacion_id', 'usuario_id', 'fecha_entrada', 'fecha_salida', 'precio_total'];
    public $timestamps = true;
}
