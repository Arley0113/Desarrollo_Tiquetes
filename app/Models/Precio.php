<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Precio extends Model
{
    use HasFactory;

    protected $table = 'precios';
    protected $primaryKey = 'id_precio';
    public $timestamps = false;

    protected $fillable = [
        'precio_ida',
        'precio_ida_vuelta',
        'id_viaje'
    ];

    protected $casts = [
        'precio_ida' => 'decimal:2',
        'precio_ida_vuelta' => 'decimal:2'
    ];

    // Relaciones
    public function tipoViaje()
    {
        return $this->belongsTo(TipoViaje::class, 'id_viaje', 'id_viaje');
    }

    public function vuelos()
    {
        return $this->hasMany(Vuelo::class, 'id_precio', 'id_precio');
    }

    public function tiquetes()
    {
        return $this->hasMany(Tiquete::class, 'id_precio', 'id_precio');
    }
}