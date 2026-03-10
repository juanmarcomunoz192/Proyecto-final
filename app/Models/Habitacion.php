<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    use HasFactory;
    protected $table = 'habitaciones';
    protected $fillable = ['hotel_id', 'numero', 'tipo', 'precio', 'esta_disponible'];
    public $timestamps = true;
}
