<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoViaje extends Model
{
    use HasFactory;

    protected $table = 'tipo_viaje';
    protected $primaryKey = 'id_viaje';
    public $timestamps = false;

    protected $fillable = [
        'nombre'
    ];

    // Relaciones
    public function precios()
    {
        return $this->hasMany(Precio::class, 'id_viaje', 'id_viaje');
    }
}