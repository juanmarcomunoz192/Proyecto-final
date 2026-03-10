<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;
    protected $table = 'hoteles';
    public $timestamps = true;
    protected $fillable = ['nombre', 'direccion', 'ciudad'];
    public function habitaciones()
    {
        return $this->hasMany(Habitacion::class);
    }
}
