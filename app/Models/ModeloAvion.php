<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModeloAvion extends Model
{
    use HasFactory;

    protected $table = 'modelo_avion';
    protected $primaryKey = 'id_avion';
    public $timestamps = false;

    protected $fillable = [
        'nombre_avion',
        'capacidad',
        'serial',
        'id_aeropuerto'
    ];

    // Relaciones
    public function aeropuerto()
    {
        return $this->belongsTo(Aeropuerto::class, 'id_aeropuerto', 'id_aeropuerto');
    }

    public function asientos()
    {
        return $this->hasMany(Asiento::class, 'id_avion', 'id_avion');
    }

    public function vuelos()
    {
        return $this->hasMany(Vuelo::class, 'id_avion', 'id_avion');
    }

    // Métodos helper
    public function tieneAsientosDisponibles($idVuelo)
    {
        $asientosOcupados = Tiquete::whereHas('vuelo', function($query) use ($idVuelo) {
            $query->where('id_vuelo', $idVuelo);
        })->count();

        return $this->capacidad > $asientosOcupados;
    }
}